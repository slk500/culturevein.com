<?php ini_set('display_startup_errors',1);ini_set('display_errors',1);error_reporting(-1); ?>

<?php
require __DIR__ . '/../vendor/autoload.php';




///////////////////////////
$db = new PDO("mysql:host=".DB_SERVER.";dbname=". DB_NAME, DB_USER, DB_PASS);
$db -> query ('SET NAMES utf8');

//////////////////////////////
$mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
}
$mysqli->set_charset("utf8");
////////////////////////////////


$connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

  if(mysqli_connect_errno()) {
    die("Database connection failed: " .
         mysqli_connect_error() .
         " (" . mysqli_connect_errno() . ")"
    );
  }
mysqli_set_charset($connection,"utf8"); //polskie znaki

function confirm_query($result_set)
{
    if (!$result_set)
	{
		die("Database query failed.");
	}
}

function convert_time($youtube_time){
    $start = new DateTime('@0'); // Unix epoch
    $start->add(new DateInterval($youtube_time));
    return $start->format('H:i:s');
}


function number_pad($number)
{
	return str_pad((int) $number,2,"0",STR_PAD_LEFT);
}



/////////////////////////////////////





// Create the SMTP configuration
$transport = Swift_SmtpTransport::newInstance("smtp.zenbox.pl", 587);
$transport->setUsername("culturevein@culturevein.com");
$transport->setPassword("password");

$div_list = "<div class='col-xs-10 col-xs-offset-1 white_container'>";



