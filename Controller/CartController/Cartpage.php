<?php

require_once 'Model/Cart.php';
require_once 'Model/Product.php';

class Cartpage
{ 
    private $cart;
    private $product;

    public function __construct(Cart $cart , Product $product) {
        $this->cart = $cart;
        $this->product = $product;
    }

    public function showCartpage()
    {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = "You need to log in to view your cart.";
            header("Location: index.php?action=login");
            exit;
        }
        else
        {
            $cart_items=$this->cart->getCartItemsByUser($_SESSION['user_id']);
            include 'View/Cartpage.php';
        }
    }

    public function removeItem($id)
    {
        $this->cart->removeItem($id);
        header("Location: index.php?action=cart");
        exit;
    }

    public function updateCart($quantities)
    {
        $_SESSION['errors'] = [];

        foreach($quantities as $id => $quantity)
        {
            $cartItem = $this->cart->getCartItemsByRowID($id);
            $productData=$this->product->get_product_stock($cartItem['product_id']);
            $stock=$productData['stock'];
            $name=$productData['name'];

            if($quantity>$stock)
            {
                $_SESSION['errors'][] = "Only $stock left for {$name}.";
            }
            else
            {
                $this->cart->updateCart($id , $quantity);
            }
        }

        header("Location: index.php?action=cart");
        exit;
    }

    public function addToCart($id)
    {
        if(isset($_SESSION['user_id']))
        {
            $this->cart->addToCart($id);
            $_SESSION['message']="added to cart";
        }
        else
        {
            $_SESSION['error']="you have to login first";
        }
        
        header("Location: ". $_SERVER['HTTP_REFERER']);
        exit;
    }
}

?>