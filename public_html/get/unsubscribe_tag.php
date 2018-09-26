<?php require_once '../../app/bootstrap.php' ?>
<?php

     $stmt = $mysqli->prepare("DELETE FROM tag_user_subscribe WHERE user_id= ? AND tag_id=?");
     $stmt->bind_param("ii",$_GET["q"],$_GET["w"]);
     $stmt->execute();
	 $stmt->close();