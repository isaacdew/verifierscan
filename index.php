<?php
include('navbar.php');
?>
<div class="container">
    <div class="row">
        <div class="col-md-6">
           <div class="panel">
                <div class="panel-body">
                    <h3>Not sure you can trust an article on the web? </h3>
                    <p class="post-content">
                        Enter the URL for the article or web page in the box above and press "Generate Report". VerifierScan will provide you with an analysis of the credibility of the article or web page in question.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6 card-border">
            <div class="panel">
                <div class="panel-body">
                    <h3>Want to help fight against misinformation?</h3>
                    <p class="post-content">
                        The number one thing you can do to fight misinformation is to make sure you're not sharing it. Run articles you're not sure about through VerifierScan. Also, be sure to like and share VerifierScan on <a href="https://www.facebook.com/verifierscan/" rel="noreferrer" target="_blank">Facebook</a>!
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="row cards">
        <div class="col-md-3">
            <div class="panel">
                <div class="panel-body">
                    <h3 class="text-center">
                        <i class="fa fa-university" aria-hidden="true"></i><br>
                        Source
                    </h3>
                    <p>
                        VerifierScan evaluates the source of the web page in question by an analysis of its parent organization.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-3 card-border">
                    <div class="panel">
                <div class="panel-body">
                    <h3 class="text-center">
                        <i class="fa fa-shield" aria-hidden="true"></i><br>
                        Security
                    </h3>
                    <p>
                        Security is evaluated based on data from Google as well as a check for an encrypted connection.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-3 card-border">
            <div class="panel">
                <div class="panel-body">
                    <h3 class="text-center">
                        <i class="fa fa-external-link" aria-hidden="true"></i><br>
                        URL
                    </h3>
                    <p>
                        VerifierScan looks for unusual characters or patterns in the URL of the web page in question.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-3 card-border">
            <div class="panel">
                <div class="panel-body">
                    <h3 class="text-center">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i><br>
                        Spelling
                    </h3>
                    <p>
                        Spelling is evaluated to gauge the quality of the writing displayed on the web page in question.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include('footer.php');
?>