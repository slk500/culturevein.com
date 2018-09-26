<?php require_once("../app/bootstrap.php"); ?>
<?php use \Cocur\Slugify\Slugify;?>
<?php

$slugify = new Slugify();

define("API_KEY", "");


$youtube_id = $_POST["youtube_id"];

$release_date = $_POST["release_date"];
$duration = getYoutubeDurationV3($youtube_id);

$artist_name = $_POST["artist_name"];
$music_video_title = $_POST["music_video_title"];
$artist_name_slug = $slugify->slugify($artist_name);
$music_video_title_slug = $slugify->slugify($music_video_title);


function getYoutubeDurationV3($id)
{
    $json = json_decode(
        file_get_contents('https://www.googleapis.com/youtube/v3/videos' .
            '?part=contentDetails&id=' . $id . '&key=' . API_KEY)
    );
    $start = new DateTime('@0');
    $youtube = new DateTime('@0');
    $youtube->add(new DateInterval($json->items[0]->contentDetails->duration));

    return $youtube->getTimestamp() - $start->getTimestamp();
}


$stmt = $mysqli->prepare("INSERT INTO video (youtube_id, name, duration, slug, release_date, type, state) VALUES (?,?,?,?,?,3,1)");
$stmt->bind_param("ssiss", $youtube_id, $music_video_title, $duration, $music_video_title_slug, $release_date);
$stmt->execute();
$stmt->close();

$video_id = $mysqli->insert_id;

$stmt = $mysqli->prepare("SELECT music_video_id FROM artist WHERE artist_name = ?");
$stmt->bind_param("s", $artist_name);
$stmt->execute();

$stmt->bind_result($music_video_id);
while ($stmt->fetch()) {
    $music_video_id = $music_video_id;
}

if (empty($music_video_id)) {
    $stmt = $mysqli->prepare("INSERT INTO artist (artist_name,slug) VALUES (?,?)");
    $stmt->bind_param("ss", $artist_name, $artist_name_slug);
    $stmt->execute();
    $stmt->close();
    $music_video_id = $mysqli->insert_id;
}

$stmt = $mysqli->prepare("INSERT INTO music_video_video (music_video_id,video_id) VALUES (?,?)");
$stmt->bind_param("ii", $music_video_id, $video_id);
$stmt->execute();
$stmt->close();

$mysqli->close();

header('Location:' . "http://culturevein.com/music-video/$artist_name_slug/$music_video_title_slug");
die;
