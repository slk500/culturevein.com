<?php require_once("../../app/bootstrap.php"); ?>
<?php

$username=$_POST["username"];
$email=$_POST["email"];
$facebook_id=$_POST["facebook_id"];

$stmt= $mysqli->prepare("SELECT username FROM user WHERE username = ? or email= ? or facebook_id= ?");
$stmt->bind_param("sss", $username, $email, $facebook_id);
$stmt->execute();
$result = $stmt->fetch();


if($result)
{
    die('The username or email is already taken. Please choose another one.');
}
else{
    $stmt = $mysqli->prepare("INSERT INTO user (username, email, facebook_id) VALUES (?,?, ?)");
    $stmt->bind_param("sss", $username, $email, $facebook_id);
    $stmt->execute();
    $stmt->close();

    $user_id = $mysqli->insert_id;

    $_SESSION['valid'] = true;
    $_SESSION['timeout'] = time();
    $_SESSION['username'] = $username;
    $_SESSION['user_id'] = $user_id;
    $_SESSION['email'] = $email;

    $_SESSION['msg'] = "Success!.Your account has been created. You are now logged-in.";

    header('Location:' . "http://culturevein.com/");
}

?>