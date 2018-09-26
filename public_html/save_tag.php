<?php require_once("../app/bootstrap.php"); ?>
<?php use Cocur\Slugify\Slugify;

$slugify = new Slugify(); ?>
<?php

$video_id = $_POST['video_id'];
$array = json_decode($_POST['tag_to_save']);

$start = $array[0];
$stop = $array[1];
$tag_title_pl = $array[2];
$duration = $array[3];
$slug = $slugify->slugify($tag_title_pl);

$zero = 0;

$stmt = $mysqli->prepare("SELECT email FROM user WHERE user_id = ?");
$stmt->bind_param("s", $user_id);
$stmt->execute();
$stmt->bind_result($tag_id);
while ($stmt->fetch()) {
    $tag_id = $tag_id;
}


$stmt = $mysqli->prepare("SELECT tag_id FROM tag WHERE name = ?");
$stmt->bind_param("s", $tag_title_pl);
$stmt->execute();
$stmt->bind_result($tag_id);
while ($stmt->fetch()) {
    $tag_id = $tag_id;
}

if (empty($tag_id)) {

    $stmt = $mysqli->prepare("INSERT INTO tag (name, slug) VALUES (?, ?)");
    $stmt->bind_param("ss", $tag_title_pl, $slug);
    $stmt->execute();
    $tag_id = $mysqli->insert_id;
}

$stmt = $mysqli->prepare("DELETE FROM tag_video WHERE video_id= ? AND tag_id=?
                              AND start=? AND stop=?");
$stmt->bind_param("iiii", $video_id, $tag_id, $zero, $duration);
$stmt->execute();
$stmt->close();

$stmt = $mysqli->prepare("INSERT INTO tag_video (tag_id, video_id, start, stop) VALUES (?, ?, ?, ?)");
$stmt->bind_param("iiii", $tag_id, $video_id, $start, $stop);
$stmt->execute();

/*
// Create the message
$message = Swift_Message::newInstance();
$message->setTo(["slawomir.grochowski@gmail.com" => "username"]);
$message->setSubject("Somebody ADD a new TAG");
$message->setBody($twig->render('links.twig'));
$message->setFrom("culturevein@culturevein.com", "CultureVein");

*/

