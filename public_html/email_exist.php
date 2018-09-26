<?php  require_once '../app/bootstrap.php' ?>
<?php

$email = $_GET["email"];

$result = NULL;

$stmt= $mysqli->prepare("SELECT username FROM user WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();

$stmt->bind_result($music_video_id);
		while ($stmt->fetch()) {
        $result = $email;}
        
                 
if($result)
  {
    echo 'false';
  }
  else{
	echo 'true';
  }
