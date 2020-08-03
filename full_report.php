<?php
include('navbar.php');
include('functions.php');
function parseArticle($url) {
    $newspaper = exec("python3 /var/www/html/python-test/index.py $url", $result, $status);
    if($status == 0) {
        $arr_result = array($result[2]);
        $num_results = count($result);
        
        for($x = 3; $x < $num_results; $x++) {
            $result = str_replace(array("[", "]", "'"), '',$result[$x]);
            array_push($arr_result, $result);
        }
        if($arr_result[1] !== "") {
            $arr_result[1] = "This article was written by " . $arr_result[1];
        } else {
            $arr_result[1] = "We're not sure who wrote this article";
        }
        return $arr_result;
    }
}
if($_GET) {
    $url = $_GET['url'];
    
    $result = parseArticle($url);
    $score = scoringFunction($url);
}
?>
<div class="container">
    <div class="row">
        <div class="panel">
            <div class="panel-body">
                <h1>
                    Full Report<br>
                    <small><?php echo $url; ?></small>
                </h1>
                <p class="post-content">
                    This website is owned by <?php echo $score['org_name']; ?> which received a Source Score of <?php echo $score['org']; ?> based on data from the Better Business Bureau. <?php echo $result[1]; ?> on <?php echo $result[0]; ?>.
                </p>
            </div>
        </div>
    </div>    
</div>
<?php
include('footer.php');
?>