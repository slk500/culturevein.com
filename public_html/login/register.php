<?php require_once("../../app/bootstrap.php"); ?>
<?php


$username=$_POST["username"];
$password = $_POST["password"];
$password_hashed = password_hash($password, PASSWORD_DEFAULT);
$email=$_POST["email"];
    
$stmt= $mysqli->prepare("SELECT username FROM user WHERE username = ? or email= ?");
$stmt->bind_param("ss", $username, $email);
$stmt->execute();
$result = $stmt->fetch();

    if($result)
      {
     die('The username or email is already taken. Please choose another one.');
      }
    else{
        $stmt = $mysqli->prepare("INSERT INTO user (username, email, password) VALUES (?,?,?)");
        $stmt->bind_param("sss", $username, $email, $password_hashed);
        $stmt->execute();
        $stmt->close();

        $user_id = $mysqli->insert_id;

        $session = new Session($username,$user_id,$email);
        $session->makeSession();
        $session->msgSuccessCreatedAccountAndLogIn();

      }

?>