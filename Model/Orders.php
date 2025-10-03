<?php

require_once 'Database.php';

class Orders
{
    private $conn;

    public function __construct(Database $database)
    {
        $this->conn = $database->get_connection();
    }

    public function makeOrder($user_id , $total , $status)
    {
        try{

            $sql = "INSERT INTO orders (user_id , total , status) VALUES (:user_id , :total , :status)";
            $stmt=$this->conn->prepare($sql);
            $stmt->bindValue(':user_id' , $user_id , PDO::PARAM_INT);
            $stmt->bindValue(':total' , $total);
            $stmt->bindValue(':status' , $status);
            $stmt->execute();
            return $this->conn->lastInsertId();

        } catch(Exception $e) {
            return false;
        }
    }

    public function getOrderById($order_id)
    {
        try{

            $sql = "SELECT id, total, status FROM orders WHERE id = :order_id";
            $stmt=$this->conn->prepare($sql);
            $stmt->bindValue(':order_id' , $order_id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);

        }
        catch (Exception $e){
            return false;
        }
    }
}


?>