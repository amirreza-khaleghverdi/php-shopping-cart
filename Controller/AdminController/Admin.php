<?php

require_once 'Model/AdminLogin.php';
require_once 'Model/Login.php';

class  AdminController
{
    private $AdminLogin;
    private $login;

    public function __construct(AdminLogin $AdminLogin, Login $login) {
        $this->AdminLogin = $AdminLogin;
        $this->login = $login;
    }

    public function showAdminPage() {
        if (isset($_SESSION['admin_name'])) {
            include 'View/admin/dashboard.php';
        }
        else {
            header("Location: : index.php?action=admin_login");
        }
    }

    public function checkLogin() {
        $username=trim($_POST['admin_name']);
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
    }


    

}

?>