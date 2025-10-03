<?php

require_once 'Database.php';

class OrderItems
{
    private $conn;

    public function __construct(Database $database) {
        $this->conn = $database->get_connection();
    }

    public function addOrderItem($order_id , $product_id , $quantity , $price)
    {
        try {

            $sql = "INSERT INTO order_items (order_id , product_id , quantity , price) VALUES (:order_id , :product_id , :quantity , :price)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':order_id' , $order_id , PDO::PARAM_INT);
            $stmt->bindValue(':product_id' , $product_id , PDO::PARAM_INT);
            $stmt->bindValue(':quantity' , $quantity , PDO::PARAM_INT);
            $stmt->bindValue(':price' , $price);
            $stmt->execute();
            return $stmt;

        } catch (Exception $e) {
            return false;
        }
    }
}

?>