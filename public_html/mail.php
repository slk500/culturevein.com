<?php
require '../app/bootstrap.php';

// Create the SMTP configuration
$transport = Swift_SmtpTransport::newInstance("smtp.zenbox.pl", 587);
$transport->setUsername("");
$transport->setPassword("");


$arr = ['lurgen@o2.pl','slawomir.grochowski@gmail.com'];


// Create the message
$message = Swift_Message::newInstance();
$message->setTo(["slawomir.grochowski@gmail.com" => "username"]);
$message->setTo($arr);
$message->setSubject("This email is sent using Swift Mailer");
$message->setBody($twig->render('mail/new_music_video_in_tag.html.twig'), 'text/html');
$message->setFrom("culturevein@culturevein.com", "CultureVein");



// Send the email
$mailer = Swift_Mailer::newInstance($transport);
$mailer->send($message, $failedRecipients);

