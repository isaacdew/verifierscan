<?php
/*
Application Name: VerifierScan
Version:1.2.0
Description: A tool for helping understand what sites are credible and what sites are not.
*/

//Make database connection
//Must make .config/ if moved to production
include('config/config.php');

//Grab URL Contents
function grabURL($url) {
    // initialise the CURL library
    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL, $url);
    
    curl_setopt($ch, CURLOPT_ENCODING, '');
    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    
    // specify the useragent: this is a required courtesy to site owners
    curl_setopt($ch, CURLOPT_USERAGENT, 'cURL');
    
    //ignore SSL errors
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //Follow redirects
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    
    curl_setopt($ch, CURLOPT_HEADER, 0);
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded;" charset=UTF-8'));
    
    $output = curl_exec($ch);    
    
    curl_close($ch);
    
    return $output;
    
}
//Base domain name
function baseDomain($url) {
    //Remove http://, https:// to be saved in Database
    $unwanted = array("http://", "https://", "www.");
    $url = str_replace($unwanted,"", $url);
    //Divide URL by slashes
    $url = explode("/",$url);
    
    //Save only the URL without slashes
    $url = $url[0];

    return $url;
}
//Check if a site has SSL
function has_ssl($domain) {
    $ssl_check = @fsockopen( 'ssl://' . $domain, 443, $errno, $errstr, 30 );
    $res = !! $ssl_check;
    if ( $ssl_check ) { fclose( $ssl_check ); }
    return $res;
}
//Retrieve title from a site
function get_title($str){
  if(strlen($str)>0){
    $str = trim(preg_replace('/\s+/', ' ', $str)); // supports line breaks inside <title>
    preg_match("/\<title\>(.*)\<\/title\>/i",$str,$title); // ignore case
    return $title[1];
  }
}
//BEGINNING OF SCORING
function scoringFunction($url) {
    //Database connection
    $conn = mysqli_connect ($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS'], $_ENV['DB_NAME']);
    //Get root domain
    $root_domain = baseDomain($url);
    
    //Search domains table for a record with the domain root
    $sql = "SELECT * FROM domains WHERE domain_root='$root_domain'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) == 1) {
        while($row = mysqli_fetch_assoc($result)) {
            $url_score = $row['url_score'];
            $sec_score = $row['sec_score'];
            $domain_id = $row['domain_id'];
            //Retrieve organization score
            $sql = "SELECT org_score, org_name FROM organizations WHERE org_id='" . $row['org_id'] . "'";
            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result) == 1) {
                while($row = mysqli_fetch_assoc($result)) {
                    $org_score = $row['org_score'];
                    $org_name = $row['org_name'];
                }
            }
        }
    } else {
        /* BEGINNING OF ORGANIZATION SCORE */
        //Retrieve BBB Rating by business URL search
        //Initialize CURL for BBB data
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.bbb.org/api/orgs/search?pageSize=1&businessUrl=' . $url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_HEADER, 0);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $_ENV['BBB_API_KEY']));

        $bbb_output = curl_exec($ch);

        curl_close($ch);

        //echo $bbb_output;

        $bbb_output = json_decode($bbb_output, true);

        $org_name = $bbb_output['SearchResults'][0]['OrganizationName'];

        $bbb_output = $bbb_output['SearchResults'][0]['RatingIcons'][0]['Url'];

        //If business URL search fails search by exact name
        if(empty($bbb_output)) {

                //Define access variables
                $username = $_ENV['WHOIS_API_USER'];
                $password = urlencode($_ENV['WHOIS_API_PASS']);
                //Initialize CURL for WHOIS data
                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, 'https://www.whoisxmlapi.com/whoisserver/WhoisService?domainName=' . $url . '&username=' . $username . '&password=' . $password . '&outPutFormat=JSON');

                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

                curl_setopt($ch, CURLOPT_HEADER, 0);

                $whois_output = curl_exec($ch);

                curl_close($ch);

                $whois_output = json_decode($whois_output, true);

                $reg_name = $whois_output['WhoisRecord']['registrant']['name'];
            
                $whois_org_name = urlencode($whois_output['WhoisRecord']['registrant']['organization']);
                //END OF WHOIS INFO RETRIEVAL
                //echo $org_name;
                //If website is privately registered then automatic source fail
                if(stripos($reg_name, "private") !== false || stripos($reg_name, "privacy") !== false || $whois_org_name === "") {
                    $org_score = 0;
                } else {
                    //Retrieve BBB Rating
                    //Initialize CURL for BBB data
                    $ch = curl_init();

                    curl_setopt($ch, CURLOPT_URL, 'https://api.bbb.org/api/orgs/search?pageSize=1&organizationName=' . $whois_org_name);

                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

                    curl_setopt($ch, CURLOPT_HEADER, 0);

                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $_ENV['BBB_API_KEY']));

                    $bbb_output = curl_exec($ch);

                    curl_close($ch);

                    $bbb_output = json_decode($bbb_output, true);

                    $org_name = $bbb_output['SearchResults'][0]['OrganizationName'];

                    $bbb_output = $bbb_output['SearchResults'][0]['RatingIcons'][0]['Url'];

                    //If organization name exact search fails search by alternative names
                    if(empty($bbb_output)) {
                        $ch = curl_init();

                        curl_setopt($ch, CURLOPT_URL, 'https://api.bbb.org/api/orgs/search?pageSize=1&altOrganizationNames=' . $whois_org_name);

                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

                        curl_setopt($ch, CURLOPT_HEADER, 0);

                        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $_ENV['BBB_API_KEY']));

                        $bbb_output = curl_exec($ch);
                        //echo $bbb_output;
                        curl_close($ch);

                        $bbb_output = json_decode($bbb_output, true);
                        

                        $org_name = $bbb_output['SearchResults'][0]['OrganizationName'];
                        
                        $bbb_output = $bbb_output['SearchResults'][0]['RatingIcons'][0]['Url'];
                        if(empty($bbb_output)) {
                            $org_score = 0;
                        }
                    }
                }
            }
            //echo $org_name;
            $sql = "SELECT * FROM organizations WHERE org_name='$org_name'";
            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result) == 1) {
                while($row = mysqli_fetch_assoc($result)) {
                    $org_score = $row['org_score'];
                    $org_id = $row['org_id'];
                }
            } else {
                //Place grades in array with single letter grades first
                $grade = array("A", "B", "C", "D", "F");
                //Check for a letter grade and return the rating if found
                foreach ($grade as $rating) {
                    if(preg_match_all("/$rating./", $bbb_output, $matches)) {
                        $bbb_rating = end($matches[0]);
                        break;
                    }
                }
    
                //Give a score based on BBB Rating
                if($bbb_rating === "A+") {
                    $org_score = 100;    
                } else if($bbb_rating === "A.") {
                    $org_score = 95;
                } else if($bbb_rating === "A-") {
                    $org_score = 92;
                } else if($bbb_rating === "B+") {
                    $org_score = 91;
                } else if($bbb_rating === "B.") {
                    $org_score = 85;
                } else if($bbb_rating === "B-") {
                    $org_score = 80;
                } else if($bbb_rating === "C+") {
                    $org_score = 77;
                } else if($bbb_rating === "C.") {
                    $org_score = 74;
                } else if($bbb_rating === "C-") {
                    $org_score = 71;
                } else if($bbb_rating === "D+") {
                    $org_score = 70;
                } else if($bbb_rating === "D.") {
                    $org_score = 68;
                } else if($bbb_rating === "D-") {
                    $org_score = 66;
                } else if($bbb_rating === "F+") {
                    $org_score = 65;
                } else if($bbb_rating === "F.") {
                    $org_score = 45;
                } else {
                    $org_score = 0;
                }

                //Store organization name, bbb rating & organization score
                $sql = "INSERT INTO organizations (org_name, bbb_rating, org_score) VALUES ('$org_name', '$bbb_rating', '$org_score');";
                $result = mysqli_query($conn, $sql);
                $org_id = mysqli_insert_id($conn);
            }
        /* END OF ORGANIZATION SCORE */
        /* BEGINNING OF URL SCORE */
            
            //Select forbidden terms from database
            $sql = "SELECT * FROM forbidden_domain_chars";
            $result = mysqli_query($conn, $sql);
            $num_results = mysqli_num_rows($result);
            $forbdn_subdomain = array();
            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    array_push($forbdn_subdomain, $row['forbidden']);
                }
            }

            //Create array of trusted top-level domains
            $trusted_tlds = array(".edu", ".mil", ".gov");
        
            $total_chars = strlen($root_domain);
            
            $forbdn_chars = str_split("1234567890-");
            $num_forbid_chars = 0;
            //Iterations are dependent on number of forbidden terms
            for ($x = 0; $x < 11; $x++) {
               $chars_add += substr_count($root_domain, $forbdn_chars[$x]);
               $domain_add += substr_count($root_domain, $forbdn_subdomain[$x]);
               $tld_sub += substr_count($root_domain, $trusted_tlds[$x]);
            }
            
            //Each subdomain irregularity is counted as 45% of the total characters and a forbidden char counts as 1
            $num_forbid_chars = ($num_forbid_chars + (($total_chars * 0.45) * $domain_add) + $chars_add) - $tld_sub;    
        
            //Calculate URL Score
            $url_score = round((($total_chars - $num_forbid_chars)/$total_chars) * 100, 2);


    /* END OF URL SCORE */
    /* BEGINNING OF SECURITY SCORE */

        //Set query data
        $http_header = array(
            "POST https://safebrowsing.googleapis.com/v4/threatMatches:find?key=" . $_ENV['GOOGLE_API_KEY'] . "HTTP/1.1", "Content-type: application/json"
        );
        $client = array(
            "clientId" => $_ENV['GOOGLE_CLIENT_ID'],
            "clientVersion" => "0.0.1"
        );
        $threat_info = array(
            "threatTypes" => array(
                "MALWARE", "SOCIAL_ENGINEERING",
            ),
            "platformTypes" => array("WINDOWS"),
            "threatEntryTypes" => array("URL"),
            "threatEntries" => array(array(
                "url" => $url,
            ))
        );
        $request_body = array(
            'client' => $client,
            'threatInfo' => $threat_info,
        );

        $json_request = json_encode($request_body, JSON_UNESCAPED_SLASHES);

        //Initialize CURL
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://safebrowsing.googleapis.com/v4/threatMatches:find?key=' . $_ENV['GOOGLE_API_KEY']);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_POST, 1);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_request);

        curl_setopt($ch, CURLOPT_HEADER, 0);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);

        $output = curl_exec($ch);

        curl_close($ch);

        //Decode JSON
        $output = json_decode($output, true);

        //Select threat type
        $goog_safety = $output['matches'][0]['threatType'];

        //Assign scores based on threat type
        if($goog_safety === 'MALWARE' || $goog_safety === 'SOCIAL_ENGINEERING') {
            $sec_score = 0;
        } else {
            //Check if site has SSL & adjust score accordingly
            $ssl_check = has_ssl($root_domain);
            if($ssl_check) {
                $sec_score = 100;
            } else {
                $sec_score = 80;
            }
        }
        
        //Retrieve organization ID from database
        $sql = "INSERT INTO domains (org_id, domain_root, url_score, sec_score) VALUES ('$org_id', '$root_domain', '$url_score', '$sec_score')";
        mysqli_query($conn,$sql);
        $domain_id = mysqli_insert_id($conn);


    /* END OF SECURITY SCORE */
}
/* BEGINNING OF SPELLING SCORE - Finish checking database first before calculating */
    //Check database for article record
    $sql = "SELECT * FROM articles WHERE article_url='$url'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) == 1){
        while($row = mysqli_fetch_assoc($result)){
            $article_id = $row['article_id'];
            $page_title = $row['article_title'];
            $spell_score = $row['writing_score'];
            $ovr_score = $row['final_score'];
        }
    } else {

        //Grab URL Contents
        $spell_output = grabURL($url);
        
        $page_title = get_title($spell_output);
        
        //If no site is fetched return NULL else continue analyzing data
        if(empty($spell_output)) {
            $spell_score = NULL;
        } else {

        //Remove JS & styles from content
        $spell_output = preg_replace('/<script[\s\S]+?<\/script>/', '', $spell_output);
        $spell_output = preg_replace('/<style[\s\S]+?<\/style>/', '', $spell_output);

        //Add space after each element to avoid jumbling of words
        $spell_output = preg_replace('/>/','$0 ',$spell_output);

        //Remove HTML Tags
        $spell_output = strip_tags($spell_output);

        //Remove special characters & numbers
        $spell_output = preg_replace('/[^A-Za-z\s]+/', '', $spell_output);

        //Separate into individual words
        $word = explode(" ", $spell_output);

        //Config pspell for GoDaddy
        $spell_lang = pspell_new("en");

        //Setup Spelling Checker
        $spell_score = 0;
        $word_count = count($word);

        //Spell check each word
        for ($x = 0; $x < $word_count; $x++) {
            if(pspell_check($spell_lang, $word[$x])) {
                $spell_score++;
            }
        }
        //Generate score
        $spell_score = round(($spell_score/$word_count) * 100, 2);

        }

    /* END OF SPELLING SCORE */
    /* BEGINNING OF OVERALL/FINAL SCORE */

        //Force overall fail if site is not secure
        if($sec_score == 0) {
            $ovr_score = 0;
        } else {
            //Score calculations keeping in mind the sum of all four as perfect scores would be 400
            $ovr_score = round((($sec_score * 3) + ($org_score * 2) + ($url_score * 3) + $spell_score)/9, 2);
        }

        //Record results
        $sql = "INSERT INTO articles (domain_id, article_url, article_title, writing_score, final_score) VALUES ('$domain_id', '$url', '$page_title', '$spell_score', '$ovr_score')";
        mysqli_query($conn, $sql);
        $article_id = mysqli_insert_id($conn);
    }
    //Record request
    $sql = "INSERT INTO requests (article_id, date_time) VALUES ('$article_id', '" . date('Y-m-d H:i:s') . "')";
    mysqli_query($conn, $sql);
    
    //Return results in an array
    $score_results = array("org"=>$org_score, "url"=>$url_score, "sec"=>$sec_score, "spell"=>$spell_score, "ovr"=>$ovr_score);
    
    //Append percentage signs
    foreach($score_results as $type => $score) {
        $score_results[$type] .= "%";
    }
    //Add URL title
    $score_results['title'] = $page_title;
    $score_results['org_name'] = $org_name;
    
    return $score_results;
}
/* END OF OVERALL SCORE */
//Letter Grade
function letterGrade($score) {
    if($score > 300) {
        $grade = "A+";
        $color = "#279244";
        $image = "Aplus.png";
        $message = "Ah, I see what you did there...Read about how VerifierScan works and why you should trust it <a href='https://verifierscan.com/faq.php'>here</a>.";
    } else if($score >= 96 && $score < 300) {
        $grade = "A+";
        $color = "#279244";
        $image = "Aplus.png";
        $message = "This web page is highly likely to be credible. Its source is reputable, there are no serious issues within the URL, it has not been reported for suspicious activity and has good writing.";
    } else if($score >= 92 && $score < 96) {
        $grade = "A";
        $color = "#3ca738";
        $image = "A.png";
        $message = "This web page is likely to be credible. No significant credibility issues have been found.";
    } else if($score >= 82 && $score < 92) {
        $grade = "B";
        $color = "#71d240";
        $image = "B.png";
        $message = "There is a good chance this web page is credible. Some small issues have been found.";
    } else if($score >= 75 && $score < 82) {
        $grade = "C";
        $color = "#dbb927";
        $image = "C.png";
        $message = "This web page could be credible but it is not likely to be. Be cautious about sharing & believing information presented on this site. Do not share this web page unless its information has been corroborated by a reputable source.";
    } else if($score >= 65 && $score < 75) {
        $grade = "D";
        $color = "#e39824";
        $image = "D.png";
        $message = "This web page has some serious concerns. We recommend that you do not share its content. It is highly likely to be false.";
    } else if($score < 65){
        $grade = "F";
        $color = "#dd4126";
        $image = "F.png";
        $message = "Do NOT share this web page. This page is not credible. It may even be used for stealing personal information or distributing malware.";
    } else if($score == NULL){
        $grade = "NA";
    }
    
    $grade = array("grade"=>$grade, "color"=>$color, "image"=>$image, "message"=>$message);
    
    return $grade;
}
//Check Fact-Checker Sites for Related Articles
function factCheck($title, $type, $page) {
    //Delay code to allow for previous code to execute
    sleep(2);
    
    if(isset($page)) {
        $offset = ($page * 10) - 9;
        //Get results from Snopes, FactCheck.org, PolitiFact, etc.
        $result = grabURL('https://www.googleapis.com/customsearch/v1?key=' . $_ENV['GOOGLE_API_KEY'] . '&cx=008453596902355217261:j9u9c7rki6s&fields=items(link,title,displayLink,snippet)&q=' . urlencode($title) . '&start=' . $offset);
    } else {
        //Get results from Snopes, FactCheck.org, PolitiFact, etc.
        $result = grabURL('https://www.googleapis.com/customsearch/v1?key=' . $_ENV['GOOGLE_API_KEY'] . '&cx=008453596902355217261:j9u9c7rki6s&fields=items(link,title,displayLink,snippet)&q=' . urlencode($title));
    }
    //JSON decode
    $result = json_decode($result, true);

    $result = $result['items'];
    
    if($type === "scan") {
        //Display Title
        $display = '<h2>Fact-Checker Results<br><small>Powered by Google</small></h2>';
        //Set number of results (starting at 0)
        $count = 4;
    } else {
        $display = "";
        $count = 10;
    }
    //Display results
    $c = 0;
    foreach($result as $i => $row) {
        if($c <= $count) {
            $display .= '<div class="search-item">
                    <a href="' . $row['link'] . '" target="_blank" rel="noreferrer"><h4>' . $row['title'] . '<br><small>' . $row['displayLink'] . '</small></h4></a>
                    <p>' . $row['snippet'] . '</p>
                  </div>';
        } else {
            break;
        }
        $c++;
    }
    
    $display = array('display'=>$display, 'page_title'=>$title);
    
    return $display;

}
?>
