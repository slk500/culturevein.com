<?php require_once '../../app/bootstrap.php' ?>
<?php


     $stmt = $mysqli->prepare("INSERT INTO tag_video (video_id,tag_id) VALUES (?,?)");
     $stmt->bind_param("ii",$_GET['video'],$_GET['tag']);
     $stmt->execute();
     $stmt->close();
     