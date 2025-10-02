<?php

require_once 'Model/Login.php';

class LoginController
{

    private $login;

    public function __construct(Login $login)
    {
        $this->login=$login;
    }

    public function showLoginForm()
    {
        require 'View/Login.php';
    }

    public function login() 
    {
    
        $username=trim($_POST['username']);
        $password=trim($_POST['password']);
        
        if(empty($username) || empty($password))
        {
            $_SESSION['error']="username or password cant be empty";
            header("Location: index.php?action=login");
            exit;
        }

        if(strlen($password) < 4)
        {
            $_SESSION['error']="password cant be less than 4 characters";
            header("Location: index.php?action=login");
            exit;
        }

        if(strlen($username) > 31)
        {
            $_SESSION['error']="username cant be more than 30 characters";
            header("Location: index.php?action=login");
            exit;
        }

        $user=$this->login->check_login($username,$password);

        if ($user) 
        {
            $_SESSION['username']=$user['name'];
            $_SESSION['user_id']=$user['id'];
            header("Location: index.php?action=homepage");
            exit;
        }

        else
        {
            $error="invalid username or password";
            $_SESSION['error']=$error;
            header("Location: index.php?action=login");
            exit;
        }
    
    }

    public function logout()
    {
        session_destroy();
        header("Location: index.php?action=homepage");
        exit;
    }
}

?>