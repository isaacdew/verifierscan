<?php
include_once('functions.php');
//Define empty variables to avoid error
$org_score = "";
$url_score = "";
$security_score = "";
$spell_score = "";
$overall_score = "";
$search = "";
$org_letter = "";
$url_letter = "";
$sec_letter = "";
$spell_letter = "";
$ovr_letter = "";

if($_GET) {
    $base_domain = baseDomain($_GET['url']);
    
    $score = scoringFunction($_GET['url']);
    
    $search = factCheck($score['title'], "scan", 1);
    $org_letter = letterGrade($score['org']);
    $url_letter = letterGrade($score['url']);
    $sec_letter = letterGrade($score['sec']);
    $spell_letter = letterGrade($score['spell']);
    $ovr_letter = letterGrade($score['ovr']);
}
?>
<head>
    <meta property="og:title" content="VerifierScan: <?php echo $score['title']; ?>"/>
    <meta property="og:image" content="http://www.verifierscan.com/styles/grades/<?php echo $ovr_letter['image']; ?>" />
    <meta property="og:description" content="<?php echo $ovr_letter['message']; ?>"/>
<?php 
include('navbar.php');
?>
<!-- Modal -->
<div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <h3 class="text-center scanning"><span>S</span><span>C</span><span>A</span><span>N</span><span>N</span><span>I</span><span>N</span><span>G</span><span>.</span><span>.</span><span>.</span></h3>
        <!--CSS Loader-->
        <div class="load-bar">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--Facebook API -->
<script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.10&appId=<?php echo $_ENV['FB_APP_ID']; ?>";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
<!--Twitter Share Button JS-->
    <script>window.twttr = (function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0],
            t = window.twttr || {};
          if (d.getElementById(id)) return t;
          js = d.createElement(s);
          js.id = id;
          js.src = "https://platform.twitter.com/widgets.js";
          fjs.parentNode.insertBefore(js, fjs);

          t._e = [];
          t.ready = function(f) {
            t._e.push(f);
          };

          return t;
        }(document, "script", "twitter-wjs"));
    </script>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h2 class="text-center">
                        Website Credibility Scores* <br>
                        <small style="word-wrap:break-word;"><?php echo $_GET['url']; ?></small>
                    </h2>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <tr>
                                <td><b>Score Category</b></td>
                                <td><b>Score</b></td>
                                <td><b>Letter Grade</b></td>
                            </tr>
                            <tr>
                                <td>Source</td>
                                <td><?php echo $score['org']; ?></td>
                                <td><?php echo $org_letter['grade']; ?></td>
                            </tr>
                            <tr>
                                <td>URL</td>
                                <td><?php echo $score['url']; ?></td>
                                <td><?php echo $url_letter['grade']; ?></td>
                            </tr>
                            <tr>
                                <td>Site Security</td>
                                <td><?php echo $score['sec']; ?></td>
                                <td><?php echo $sec_letter['grade']; ?></td>
                            </tr>
                            <tr>
                                <td>Spelling</td>
                                <td><?php echo $score['spell']; ?></td>
                                <td><?php echo $spell_letter['grade']; ?></td>
                            </tr>
                            <tr class="result-row">
                                <td><b>Overall Score:</b></td>
                                <td style="color:<?php echo $ovr_letter['color'] ;?>"><b><?php echo $score['ovr']; ?></b></td>
                                <td style="color:<?php echo $ovr_letter['color'] ;?>"><b><?php echo $ovr_letter['grade']; ?></b></td>
                            </tr>
                        </table>
                    </div>
                    <p class="post-content" style="color:<?php echo $ovr_letter['color'] ;?>">
                        <b><?php echo $ovr_letter['message']; ?></b>
                    </p>
                    <small>*This score card is generated by a number of different factors and is not always accurate. Score inaccuracies can be caused by a lack of data. Please <a href="contact.php">contact us</a> if you think a score has been inaccurate or have a suggestion. Click <a href="why.php?url=<?php echo $_GET['url'] ?>" target="_blank" rel="noreferrer">here</a> to learn why this URL got this score.</small>
                    <!--Share Results Form-->
                    <div class="share-buttons">
                        <a id="shareBtn" class="btn facebook-btn"><i class="fa fa-facebook fa-lg" aria-hidden="true"></i> Post</a>
                        <a class="twitter-share-button" href="https://twitter.com/share" data-size="large" data-text="'<?php echo $search['page_title']; ?>'-<?php echo $base_domain; ?> got a credibility score of <?php echo $score['ovr']; ?>. <?php echo $ovr_letter['message']; ?>" data-url="https://verifierscan.com/results.php?url=<?php echo $_GET['url']; ?>" data-hashtags="verifierscan,fightfakenews" data-related="aristocode,aristos_design">Tweet</a>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel">
                <div class="panel-body" id="search">
                   <!--Search Snopes, FactCheck.org & Politifact-->
                    <?php echo $search['display']; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

//Facebook Share
document.getElementById('shareBtn').onclick = function() {
  FB.ui({
    method: 'share',
    display: 'popup',
    quote: '"<?php echo $search['page_title']; ?>" from <?php echo $base_domain; ?> received an overall credibility score of <?php echo $score['ovr']; ?> from VerifierScan. Conclusion: "<?php echo $ovr_letter['message']; ?>"',
    href: 'http://verifierscan.com/results.php?url=<?php echo $_GET['url']; ?>',
  }, function(response){});
}
</script>
<?php
include('footer.php');
?>
