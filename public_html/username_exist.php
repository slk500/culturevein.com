<?php  require_once '../app/bootstrap.php' ?>
<?php

$username = $_GET["username"];

$result = NULL;

$stmt= $mysqli->prepare("SELECT username FROM user WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();

$stmt->bind_result($music_video_id);
		while ($stmt->fetch()) {
        $result = $username;}

echo ($result)  ? "false" : "true";
