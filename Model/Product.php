<?php

require_once 'Database.php';

class Product
{
    private $conn;

    public function __construct(Database $database)
    {
        $this->conn = $database->get_connection();
    }

    public function get_latest_products()
    {
        $sql = "SELECT * FROM products ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_latest_products_limit($limit)
    {
        $sql = "SELECT * FROM products ORDER BY created_at DESC LIMIT :limit";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_product_details($product_id)
    {
        $sql = "SELECT * FROM products WHERE id =:product_id";
        $stmt=$this->conn->prepare($sql);
        $stmt->bindValue(':product_id' , $product_id , PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function get_product_stock($product_id)
    {
        $sql = "SELECT name,stock FROM products WHERE id =:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id' , $product_id , PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}