<?php require_once '../../app/bootstrap.php' ?>
<?

$zero = 0;
$duration = $_GET['duration'];

     $stmt = $mysqli->prepare("DELETE FROM tag_video WHERE video_id= ? AND tag_id=?
                              AND start=$zero AND stop=$duration");
     $stmt->bind_param("ii",$_GET['video'],$_GET['tag']);
     $stmt->execute();
	 $stmt->close();