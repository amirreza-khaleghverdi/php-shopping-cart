<?php

require_once 'Model/Login.php';

class RegisterController
{

    private $usermodel;

    public function __construct(Login $usermodel)
    {
        $this->usermodel=$usermodel;
    }
 
    public function register()
    {

        $username=$_POST['username'];
        $password=$_POST['password'];

        if(empty($username) || empty($password))
        {
            $_SESSION['error']="username or password cant be empty";
            header("Location: index.php?action=register");
            exit;
        }

        if(strlen($password) < 4)
        {
            $_SESSION['error']="password cant be less than 4 letters";
            header("Location: index.php?action=register");
            exit;
        }

        if(strlen($username) > 31)
        {
            $_SESSION['error']="username cant be more than 30 characters";
            header("Location: index.php?action=register");
            exit;
        }

        $user=$this->usermodel->register($username,$password);

        if($user)
        {
            $_SESSION['username']=$user['name'];
            $_SESSION['user_id']=$user['id'];
            header("Location: index.php?action=homepage");
            exit;
        }
        else
        {
            $_SESSION['error']="something went wrong try again later";
            header("Location: index.php?action=register");
            exit;
        }
        

    
    }

    public function showRegisterForm()
    {
        require 'View/Register.php';
    }
    
}

?>