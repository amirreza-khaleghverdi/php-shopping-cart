<?php

require_once 'Model/OrderItems.php';
require_once 'Model/Orders.php';

class ViewOrdersDetails
{
    private $order_items;
    private $orders;

    public function __construct(OrderItems $order_items, Orders $orders) {
        $this->order_items = $order_items;
        $this->orders = $orders;
    }

    public function ViewOrderItems($order_id)
    {
        $order = $this->orders->getOrderById($order_id);
        $items = $this->order_items->getOrderItemsByOrderId($order_id);
        include 'View/OrderDetails.php';
    }
}


?>