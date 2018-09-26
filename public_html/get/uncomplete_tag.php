<?php require_once '../../app/bootstrap.php' ?>
<?


     $stmt = $mysqli->prepare("DELETE FROM tag_video WHERE video_id= ? AND tag_id=?
                              AND start IS NULL AND stop is NULL");
     $stmt->bind_param("ii",$_GET['video'],$_GET['tag']);
     $stmt->execute();
	 $stmt->close();