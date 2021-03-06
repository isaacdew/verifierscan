<?php
include('navbar.php');
?>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel">
                <div class="panel-body">
                    <h1>VerifierScan Scoring System</h1>
                    <p class="post-content">VerifierScan's general methods of determining credibility are based, in part, on recommendations by <a href="http://guides.library.harvard.edu/fake">Harvard</a> for identifying fake news. Harvard mentions "Considering the source", "Checking the URL" and "Looking for visual clues". VerifierScan does all of this automatically and generates scores based on each category.</p>
                    <p class="post-content">VerifierScan credibility scores are automatically generated by an algorithm that collects specific data on each site it analyzes. It takes into account who owns the site (source score), what characters or words are in the URL (URL score), if the site has been reported for phishing or malware (security score) and the spelling on the site (spelling score). Of course, each of these scores vary in importance. This is why each score has a weight of high, medium or low that is taken into account when calculating the overall score.</p>
                    <p class="post-content">Since the overall score takes into account weights, this is the score you should pay most attention to. At times, a site may receive an "A" in every category but one and receive a "D" overall. This is because the one score that didn't receive an "A" may be weighted higher. With score weights, VerifierScan is more accurate.</p>
                    <p class="post-content">The goal of VerifierScan is to put a stop to the spread of false stories by untrustworthy sites in such a way that removes bias. Since VerifierScan uses the same method to determine the credibility of every site, there is no need to worry about an agenda. A score is what it is and all sites are held to the same standards. For more information on our mission see "<a href="mission.php">Our Mission</a>".</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include('footer.php');
?>