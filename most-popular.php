<?php
include("navbar.php");
include("functions.php");

//Function for limiting chars in a string to 55
function stringLimit($string) {
    $string = (strlen($string) > 55) ? substr($string, 0, 55) . '...' : $string;
    return $string;
}
//Get most commonly assessed URLs
$sql = "SELECT requests.article_id, COUNT(requests.article_id) AS occurrences, articles.final_score, articles.article_url, articles.article_title FROM requests INNER JOIN articles ON requests.article_id=articles.article_id GROUP BY requests.article_id ORDER BY occurrences DESC LIMIT 6";
$result = mysqli_query($conn, $sql);
?>
<div class="container">
    <h1 class="text-center">Most Popular<br><small>Be careful following links with low scores.</small></h1>
    <div class="row">
       <?php 
        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $grade = letterGrade($row['final_score']);
                echo '<div class="col-md-4">
                        <div class="panel popular-card">
                            <div class="panel-body">
                                <h4>' . stringLimit($row['article_title']) . '</h4>
                                <div class="letter-grade">
                                    <h1 class="text-center" style="color:' . $grade['color'] . '">' . $grade['grade'] . '</h1>
                                </div>
                                Link: <a href="' . $row['article_url'] . '" target="_blank" rel="noreferrer">' . stringLimit($row['article_url']) . '</a><br>
                            </div>
                            <form action="results.php" method="post">
                                <input type="hidden" name="url" value="' . $row['article_url'] . '">
                                <button class="btn btn-primary popular-card-btn" style="background-color:' . $grade['color'] . '">
                                    View Score Card
                                </button>
                            </form>
                        </div>
                    </div>';
            }
        }
        ?>
        </div>
</div>
<?php
include("footer.php");
?>