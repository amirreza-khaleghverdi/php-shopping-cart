<?php
session_start();

$action = $_GET['action'] ?? 'homepage';

require_once 'Model/Database.php';
require_once 'Model/Login.php';
require_once 'Model/Product.php';
require_once 'Model/Cart.php';
require_once 'Model/OrderItems.php';
require_once 'Model/Orders.php';
require_once 'Controller/LoginController/Login.php';
require_once 'Controller/LoginController/Register.php';
require_once 'Controller/HomeController/Homepage.php';
require_once 'Controller/CartController/Cartpage.php';
require_once 'Controller/ViewController/Viewpage.php';
require_once 'Controller/CheckoutController/Checkout.php';



$dataBase = new Database();
$Login = new Login($dataBase);
$Product = new Product($dataBase);
$Cart = new Cart($dataBase);
$Orders = new Orders($dataBase);
$OrderItems = new OrderItems($dataBase);

$loginController = new LoginController($Login);
$registerController = new RegisterController($Login);
$homepageController = new Homepage($Product);
$cartpageController = new Cartpage($Cart , $Product);
$viewpageController = new Viewpage($Product);
$checkoutController = new checkout($Orders , $OrderItems , $Cart);



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
    
    case 'showCheckout':
        if(isset($_GET['user_id'])) {

        }

    default:
        echo "404 Page Not Found";
        break;
}
