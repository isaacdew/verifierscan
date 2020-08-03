<?php
include_once('functions.php');
//Define empty variables to avoid error
$ovr_letter = "";
$score = "";
if($_GET) {
    $sql = "SELECT * FROM articles WHERE article_url = '" . $_GET['url'] . "'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) == 1) {
        while($row = mysqli_fetch_assoc($result)) {
            $score = $row['final_score'] . '%';
            $ovr_letter = letterGrade($score);
        }
    } else {
        $score = "<img src='verifierscan_logo_2.png' height='20px'>";
        $ovr_letter['color'] = "";
    }   
}
?>
<div style="width:65px; text-align:center">
    <a style="color:<?php echo $ovr_letter['color'];?>; text-decoration:none" href="https://verifierscan.com/results.php?url=<?php echo $_GET['url']; ?>" target="_blank" rel="noreferrer"><b><?php echo $score; ?></b></a>
</div>
                        