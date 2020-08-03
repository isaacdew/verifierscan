<?php
include('navbar.php');
?>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel">
                <div class="panel-body">
                    <h1>Frequently Asked Questions</h1>
                    <a role="button" data-toggle="collapse" href="#whyTrust" expanded="false" aria-controls="whyTrust"><h3>Why should you trust VerifierScan?</h3></a>
                    <p class="post-content collapse" id="whyTrust">
                        VeriferScan pulls data it uses to generate results from trusted organizations like the <a href="https://www.bbb.org/en/us/">Better Business Bureau</a>. Other data such as site security data is pulled from Google's database of billions of known security threats. The methods used by VerifierScan for identifying untrustworthy sites and fake news are based on methods recommended by Harvard.
                    </p>
                    <a role="button" data-toggle="collapse" href="#difference" expanded="false" aria-controls="difference"><h3>What is the difference between VerifierScan & other fake news flagging tools?</h3></a>
                    <p class="post-content collapse" id="difference">
                        The difference between VerifierScan and other tools is that VerifierScan dynamically generates scores in real-time based on a set of factors. Other tools like VerifierScan check against a database of known fake news sites. In other words, if a site is not in their database, they will not flag it as fake news. VerifierScan will present scores for even unknown sites.
                    </p>
                    <a role="button" data-toggle="collapse" href="#factchecker" expanded="false" aria-controls="difference"><h3>Is VerifierScan a fact-checker?</h3></a>
                    <p class="post-content collapse" id="factchecker">
                        No, VerifierScan does not fact-check the content of a web page. However, on the VerifierScan website, related results from trusted fact-checking sites are shown. You can also use our FactCheck Search tool to search terms and get results back from trusted fact-checking sites.
                    </p>
                    <a role="button" data-toggle="collapse" href="#factorMeaning" expanded="false" aria-controls="factorMeaning"><h3>What does each factor mean?</h3></a>
                    <ul class="list-unstyled post-content collapse" id="factorMeaning">
                        <li><b>Source</b> refers to the credibility of the organization that owns the website in question. This factor is based on the organization's rating from the Better Business Bureau.</li>
                        <li><b>URL</b> scores are based on the number of irregularities in the URL. Some characters or patterns in the URL of a webpage can flag it as being untrustworthy.</li>
                        <li><b>Site security</b> is based on whether the site has been reported for phishing or distributing malware and if the site has an encrypted connection. VerifierScan checks a database with billions of known threats.</li>
                        <li><b>Spelling</b> is based on exactly what it sounds like. Often, misleading or untrustworthy websites have issues with spelling.</li>
                    </ul>
                    <a role="button" data-toggle="collapse" href="#factorWeight" expanded="false" aria-controls="factorWeight"><h3>How is each factor weighted in overall scoring?</h3></a>
                    <div class="collapse" id="factorWeight">
                        <p class="post-content">
                            A factor is weighted based on the logical impact it would have on credibility as well as how often the data that factor is dependent on is accurate. For example, a website that has been reported for distributing viruses is much less likely to be credible than a site that simply has a few spelling errors.
                        </p>
                        <p class="post-content">
                            This is especially true given that spell checkers are prone to return false positives for misspelled words. However, if a site has been found to disribute viruses the data is pretty straight forward. Given this, site security is weighted much higher than spelling. Other factors are weighted likewise. Weighting is on a scale of 1 to 3 (low to high).
                        </p>
                    </div>
                    <a role="button" data-toggle="collapse" href="#political" expanded="false" aria-controls="political"><h3>Is VerifierScan politically motivated?</h3></a>
                    <p class="post-content collapse" id="political">
                        No, VerifierScan is not politically motivated. We recognize that there are false stories spread online advocating many sides of the political spectrum. Our goal is the triumph of truth. We believe this will help rein in the anger and divisiveness we have seen in our country.
                    </p>
                    <a role="button" data-toggle="collapse" href="#funding" expanded="false" aria-controls="funding"><h3>How is VerifierScan funded & maintained?</h3></a>
                    <p class="post-content collapse" id="funding">
                        VerifierScan is funded and maintained by <a href="https://aristostechnologies.com">Aristos Technologies LLC</a>. Aristos Technologies is planning to use ads to fund this site in the future.
                    </p><br>
                    <p class="text-center">If you have any other questions, please <a href="contact.php">contact us</a>.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include('footer.php');
?>