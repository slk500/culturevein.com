<?php require_once '../../app/bootstrap.php' ?>
<?php

$user_id = $_GET["q"];
$tag_id = $_GET["w"];

     $stmt = $mysqli->prepare("INSERT INTO tag_user_subscribe (user_id,tag_id) VALUES (?,?)");
     $stmt->bind_param("ii",$user_id, $tag_id);
     $stmt->execute();
     $stmt->close();

// Create the message
$message = Swift_Message::newInstance();
$message->setTo(["slawomir.grochowski@gmail.com" => "username"]);
$message->setSubject("Subscribe TAG");
$message->setBody("You're our best client ever.");
$message->setFrom("culturevein@culturevein.com", "CultureVein");

// Send the email
$mailer = Swift_Mailer::newInstance($transport);
$mailer->send($message, $failedRecipients);


