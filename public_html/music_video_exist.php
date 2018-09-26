<?php  require_once '../app/bootstrap.php' ?>
<?php

$youtube_id = $_GET["youtube_id"];

$result = NULL;

$stmt= $mysqli->prepare("SELECT video_id FROM video WHERE youtube_id = ?");
$stmt->bind_param("s", $youtube_id);
$stmt->execute();

$stmt->bind_result($result);
$stmt->fetch();

echo ($result)  ? "false" : "true";
