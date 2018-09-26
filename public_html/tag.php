<?php
require '../app/bootstrap.php';

$subscribe = false;

if (isset($_SESSION["user_id"])) {

    $user_id = $_SESSION["user_id"];

    $stmt= $mysqli->prepare("SELECT user.user_id
                                   FROM tag_user_subscribe
                                   JOIN user ON user.user_id = tag_user_subscribe.user_id
                                   WHERE tag_id = ? AND user.user_id = ?");

    $stmt->bind_param("ii", $tag_id, $user_id);
    $stmt->execute();
    $subscribe = $stmt->fetch();
}

$stmt ->free_result();

$stmt= $mysqli->prepare("SELECT count(tag_id) FROM tag_user_subscribe WHERE tag_id = ?");

$stmt->bind_param("s", $tag_id );
$stmt->execute();
$stmt->bind_result($subscribers_number);

while ($stmt->fetch()) {

    $subscribers_number = $subscribers_number;

}

echo $twig->render('tag.twig', [

    'db_data' => $db_data,
    'subscribe' => $subscribe,
    'tag_id' => $tag_id,
    'subscribers_number' => $subscribers_number
]);
 
								  
								  

