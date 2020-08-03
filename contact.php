<?php
include('navbar.php');
if($_POST) {
    $message = $_POST['message'];
    $headers = 'From: ' . $_POST['email'] . "\r\n" .
    'Reply-To: ' . $_POST['email'] . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
    
    //Send email
    if(mail('test@example.com', 'VerifierScan Contact', $message, $headers)) {
        $alert = '<div class="alert alert-success" role="alert">Success! Your email has sent!</div>';
    } else {
        $alert = '<div class="alert alert-danger" role="alert">Sorry! Your email failed to send.</div>';
    }
}
?>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel">
                <div class="panel-body">
                   <?php echo $alert; ?>
                    <h1>Contact Us<br><small>Ask us a question or provide us with feedback.</small></h1>
                    <form action="contact.php" method="post">
                        <div class="form-group">
                            <input type="text" name="name" class="form-control" placeholder="Name">
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <textarea rows="6" name="message" class="form-control" placeholder="Your message..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary form-control">Send</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

include('footer.php');
?>
