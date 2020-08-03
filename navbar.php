<html lang="en">
<?php if(empty($_GET['url'])) { ?>
<head>
<?php } ?>
    <title>VerifierScan</title>
    <link rel="icon" href="verifierscan_logo_2.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#009048">
    <meta name="keywords" content="verifierscan,fake news identifier,how to identify fake news,fake news tool,misinformation,fake news checker">
    <meta name="description" content="Not sure how to identify fake news? Just enter a URL and VerifierScan will generate a crediblity score.">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link href="styles/style.min.css" rel="stylesheet">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
     <script>
		// Wait for window load
		$(window).load(function() {
			// Animate loader off screen
			$(".modal").hide();
		});
	</script>
	<script src="https://use.fontawesome.com/635f1a29ae.js" defer="defer"></script>
</head>
<body>
    <div class="main-header">
        <div class="navbar navbar-inverse navbar-static-top">
            
            <div class="container">
                
                
                <button class="navbar-toggle" data-toggle="collapse" data-target=".navHeaderCollapse">
                    
                <span class="icon-bar"></span>
                 <span class="icon-bar"></span>
                 <span class="icon-bar"></span>
                
                </button>
                <div class="collapse navbar-collapse navHeaderCollapse">
                    
                    <ul class="nav navbar-nav navbar-left">
                        <li><a href="index.php">Home</a></li>
                        <!--<li><a href="most-popular.php">Most Popular</a></li>-->
                        <li><a href="factcheck-search.php">FactCheck Search</a></li>
                        <li><a href="scoring-system.php">How It Works</a></li>
                        <li><a href="faq.php">FAQ</a></li>
                        <li><a href="download.php">Downloads</a></li>
                        <!--<li><a href="/blog/">Blog</a></li>-->
                    </ul>
                
                </div>
            </div>
    
        </div>
       
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
        <div class="header-content">
            <div class="brand">
                <h1><img src="verifierscan_logo_2.png" class="logo"><span>V</span>erifierScan</h1><br>
            </div>
            <form action="results.php" method="get" class="text-center header-form">
                <input type="text" class="header-input" name="url" placeholder="https://example.com">
                <button class="btn btn-header" data-toggle="modal" data-target=".modal">
                    Generate Report
                </button>
            </form>
        </div>
    </div>
<!-- Modal -->
<div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display:none">
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
    