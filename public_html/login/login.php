<?php require_once("../../app/bootstrap.php"); ?>
<?php

$username = $_POST["username"];
$password = $_POST["password"];


$stmt= $mysqli->prepare("SELECT password, user_id, email FROM user WHERE username = ? OR email = ?");
$stmt->bind_param("ss", $username, $username );
$stmt->execute();
$stmt->bind_result($hashed_password, $user_id, $email);

while ($stmt->fetch()) {
    $hashed_password = $hashed_password;
    $user_id = $user_id;
    $email = $email;
}

if(password_verify($password, $hashed_password)){

    $session = new Session($username,$user_id,$email);
    $session->makeSession();
    $session->msgSuccessLogIn();

}else{

    $_SESSION['msg'] = "Logon failure: Unknown user or bad password.";

    header('Location:' . "http://culturevein.com/login");

}
