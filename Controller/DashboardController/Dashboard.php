<?php

require_once 'Model/Orders.php';
require_once 'Model/OrderItems.php';
require_once 'Model/Login.php';


class Dashboard
{
    private $orders;
    private $order_items;
    private $login;

    public function __construct(Orders $orders, OrderItems $order_items, Login $login) {

        $this->orders=$orders;
        $this->order_items=$order_items;
        $this->login=$login;

    }

    public function showDashboard()
    {
        $orders=$this->orders->getLatestOrdersByUserId($_SESSION['user_id']);
        $order_stats=$this->orders->getOrderStatsByUserId($_SESSION['user_id']);
        include 'View/Dashboard.php';
    }

    public function changePassword($password)
    {
        $password=trim($_POST['password']);
        
        if(empty($password))
        {
            $_SESSION['error']="password cant be empty";
            header("Location: index.php?action=login");
            exit;
        }

        if(strlen($password) < 4)
        {
            $_SESSION['error']="password cant be less than 4 characters";
            header("Location: index.php?action=login");
            exit;
        }
        else
        {
            $this->login->change_password($_SESSION['user_id'], $password);
            $_SESSION['message']="password changed successfully";
        }
        
        header("Location: index.php?action=dashboard");
    }

}