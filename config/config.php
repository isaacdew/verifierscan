<?php
// Define these as constants so that they can’t be changed
//Must change if moved to production
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']);
$dotenv->load();

if ($conn = mysqli_connect ($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS'], $_ENV['DB_NAME'])) {
    
} else {

trigger_error("Could not connect to MySQL!<br /> ");

exit();

}

?>
