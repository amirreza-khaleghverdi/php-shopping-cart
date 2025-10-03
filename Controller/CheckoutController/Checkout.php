<?php

require_once 'Model/Orders.php';
require_once 'Model/Cart.php';
require_once 'Model/OrderItems.php';


class checkout
{
    private $orders;
    private $cart;
    private $order_items;

    public function __construct(Orders $orders , OrderItems $order_items , Cart $cart) {
        $this->orders = $orders;
        $this->order_items = $order_items;
        $this->cart = $cart;
        
    }

    public function Checkout()
    {
        $cart_items=$this->cart->getCartItemsByUser($_SESSION['user_id']);

        $total =0;
        foreach($cart_items as $item)
        {
            $total+=$item['price'];
        }

        $order_id = $this->orders->makeOrder($_SESSION['user_id'] , $total , 'pending');

        foreach($cart_items as $item)
        {
            $this->order_items->addOrderItem($order_id , $item['product_id'] , $item['quantity'] , $item['price']);
        }

        header("Location: index.php?action=order_confirmation&order_id=$order_id");

    }

}

?>