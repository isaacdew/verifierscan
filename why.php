<?php
include('functions.php');
include('navbar.php');

$score = scoringFunction($_GET['url']);


//Find BBB rating
if($score['org'] == 100) {
    $bbb_rating = "A+";    
} else if($score['org'] == 95) {
    $bbb_rating = "A";
} else if($score['org'] == 92) {
    $bbb_rating = "A-";
} else if($score['org'] == 91) {
    $bbb_rating = "B+";
} else if($score['org'] == 85) {
    $bbb_rating = "B";
} else if($score['org'] == 80) {
    $bbb_rating = "B-";
} else if($score['org'] == 77) {
    $bbb_rating = "C+";
} else if($score['org'] == 74) {
    $bbb_rating = "C";
} else if($score['org'] == 71) {
    $bbb_rating = "C-";
} else if($score['org'] == 70) {
    $bbb_rating = "D+";
} else if($score['org'] == 68) {
    $bbb_rating = "D";
} else if($score['org'] == 66) {
    $bbb_rating = "D-";
} else if($score['org'] == 65) {
    $bbb_rating = "F+";
} else if($score['org'] == 45) {
    $bbb_rating = "F";
} else {
    $bbb_rating = "missing";
}

//URL Score
if($score['url'] == 100) {
    $url_message = "nothing unusual";
} else if($score['url'] < 100 && $score['url'] > 55) {
    $url_message = "some minor irregularities";
} else if($score['url'] >= 55) {
    $url_message = "some major issues such as multiple generic Top-level domains (.com, .net, etc.) or a blog domain (.wordpress.com, .blogspot.com, etc.)";
}

//Security Score
if($score['sec'] == 100) {
    $sec_message = "that this URL had not been reported for any malware or phishing and had a secure connection";
} else if($score['sec'] == 80) {
    $sec_message = "that this URL had not been reported for any malware or phishing but did not have a secure connection";
} else {
    $sec_message = "that this URL had been reported for malware or phishing";
}

?>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel">
                <div class="panel-body">
                    <h1>Why did this URL receive a score of <?php echo $score['ovr'] ?>?</h1>
                    <h3>Source Score</h3>
                    <p class="post-content">
                        After finding the owner of this site, we searched the Better Business Bureau's records and found that their rating was <?php echo $bbb_rating ?>.
                    </p>
                    <h3>URL Score</h3>
                    <p class="post-content">
                        After searching this URL's domain for unusual patterns, we found <?php echo $url_message ?>.
                    </p>
                    <h3>Security Score</h3>
                    <p class="post-content">
                        After searching Google's SafeBrowsing database and checking for a secure connection, we found <?php echo $sec_message ?>.
                    </p>
                    <h3>Spelling Score</h3>
                    <p class="post-content">
                        <?php echo $score['spell'] ?> is the approximate percentage of words spelled correctly on the page.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include('footer.php');
?>