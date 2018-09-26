<?php


class Session
{
    private $username;
    private $user_id;
    private $email;

    public function __construct($username, $user_id, $email)
    {
        $this->username = $username;
        $this->user_id = $user_id;
        $this->email = $email;
    }

    public function makeSession()
    {
        $_SESSION['valid'] = true;
        $_SESSION['timeout'] = time();
        $_SESSION['username'] = $this->username;
        $_SESSION['user_id'] = $this->user_id;
        $_SESSION['email'] = $this->email;

        header('Location:' . "http://culturevein.com/");
    }

    public function msgSuccessLogIn()
    {
        $_SESSION['msg'] = "Success!.You are now logged-in.";
    }

    public function msgSuccessCreatedAccountAndLogIn()
    {
        $_SESSION['msg'] = "Success!.Your account has been created. You are now logged-in.";
    }



}




