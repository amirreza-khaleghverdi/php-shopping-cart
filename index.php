<?php
session_start();

$action = $_GET['action'] ?? 'homepage';

require_once 'Model/Database.php';
require_once 'Model/Login.php';
require_once 'Model/Product.php';
require_once 'Model/Cart.php';
require_once 'Model/OrderItems.php';
require_once 'Model/Orders.php';
require_once 'Model/AdminLogin.php';

require_once 'Controller/LoginController/Login.php';
require_once 'Controller/LoginController/Register.php';
require_once 'Controller/HomeController/Homepage.php';
require_once 'Controller/CartController/Cartpage.php';
require_once 'Controller/ViewController/Viewpage.php';
require_once 'Controller/CheckoutController/Checkout.php';
require_once 'Controller/DashboardController/Dashboard.php';
require_once 'Controller/ViewOrderDetails/ViewOrdersDetails.php';
require_once 'Controller/AdminController/Admin.php';



$dataBase = new Database();
$Login = new Login($dataBase);
$Product = new Product($dataBase);
$Cart = new Cart($dataBase);
$Orders = new Orders($dataBase);
$OrderItems = new OrderItems($dataBase);
$Admin = new AdminLogin($dataBase);

$loginController = new LoginController($Login);
$registerController = new RegisterController($Login);
$homepageController = new Homepage($Product);
$cartpageController = new Cartpage($Cart , $Product);
$viewpageController = new Viewpage($Product);
$checkoutController = new checkout($Orders , $OrderItems , $Cart);
$dashboardController = new Dashboard($Orders, $OrderItems, $Login);
$vieworderdetails = new ViewOrdersDetails($OrderItems , $Orders);
$adminController = new AdminController($Admin, $Login);




$method = $_SERVER['REQUEST_METHOD'];

switch ($action) 
{
    case 'login':
        $loginController->showLoginForm(); 
        break;

    case 'doLogin':
        if($method == 'POST')
        {
            $loginController->login();
        }
        break;

    case 'homepage':
        $homepageController->showHomepage();
        break;

    case 'logout':
        $loginController->logout();
        break;

    case 'register':
        $registerController->showRegisterForm();
        break;

    case 'doRegister':
        if($method == 'POST')
        {
            $registerController->register();
        }
        break;

    case 'cart':
        $cartpageController->showCartpage();
        break;

    case 'remove_item':
        $cartpageController->removeItem($_GET['cart_item_id']);
        break;

    case 'update_cart':
        if(isset($_POST['quantities']))
        {
            $cartpageController->updateCart($_POST['quantities']);
        }
        break;
    
    case 'add_to_cart':
        if (isset($_POST['product_id'])) {
            $cartpageController->addToCart((int)$_POST['product_id']);
        }
        break;

    case 'view':
        if(isset($_GET['product_id'])){
            $viewpageController->showViewpage($_GET['product_id']);
        }
        break;
    
    case 'show_confirmation':
        if (isset($_SESSION['user_id'])) {
            $checkoutController->Checkout();
        } else {
            header("Location: index.php?action=login");
            exit;
        }
        break;
    
    case 'confirm_order':
        if($method == 'POST' && isset($_POST['order_id'])){
            $checkoutController->confirmOrder($_POST['order_id']);
        }
        break;

    case 'cancel_order':
        if($method == 'POST' && isset($_POST['order_id'])){
            $checkoutController->cancelOrder($_POST['order_id']);
        }
        break;

    case 'dashboard':
            $dashboardController->showDashboard();
        break;

    case 'change_password':
        if($method == 'POST'){
            $dashboardController->changePassword($_POST['password']);
        }
        break;

    case 'view_order_details':
            $vieworderdetails->ViewOrderItems($_GET['order_id']);
        break;

    case 'admin':
        $adminController->showAdminPage();
        break;
    
    case 'admin_login':
        if ($method == 'POST') {
            $adminController->checkLogin();
        }
        break;


    default:
        echo "404 Page Not Found";
        break;
}
