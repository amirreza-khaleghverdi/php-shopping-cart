<?php

require_once 'Model/AdminLogin.php';

require_once 'Model/Orders.php';
require_once 'Model/Product.php';
require_once "Model/Login.php";

class  AdminController
{
    private $AdminLogin;
    private $orders;
    private $products;
    private $login;

    public function __construct(AdminLogin $AdminLogin, Orders $orders, Product $products, Login $login) {
        $this->AdminLogin = $AdminLogin;
        $this->orders = $orders;
        $this->products = $products;
        $this->login = $login;
    }

    public function showAdminPage() {
        if (isset($_SESSION['admin_name'])) {
            $orders = $this->orders->getAllOrders();
            $products = $this->products->get_latest_products();
            $users = $this->login->get_all_users();
            include 'View/admin/dashboard.php';
        }
        else {
            header("Location: index.php?action=showAdminLogin");
        }
    }

    public function showLoginPage() {
        include 'View/admin/login.php';
    }

    public function checkLogin() {
        $username=trim($_POST['admin_name']);
        $password=trim($_POST['password']);
        
        if(empty($username) || empty($password))
        {
            $_SESSION['error']="username or password cant be empty";
            header("Location: index.php?action=homepage");
            exit;
        }

        if(strlen($password) < 4)
        {
            $_SESSION['error']="password cant be less than 4 characters";
            header("Location: index.php?action=homepage");
            exit;
        }

        if(strlen($username) > 31)
        {
            $_SESSION['error']="username cant be more than 30 characters";
            header("Location: index.php?action=homepage");
            exit;
        }

        $admin=$this->AdminLogin->check_login($username,$password);

        if ($admin) 
        {
            $_SESSION['admin_name']=$admin['name'];
            $_SESSION['admin_id']=$admin['id'];
            header("Location: index.php?action=admin");
            exit;
        }
    }

    public function register()
    {
        $username= "admin";
        $password= "admin1234";

        $this->AdminLogin->register($username,$password);
    }
}

?>