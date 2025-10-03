<?php

require_once 'Database.php';

class Cart
{
    private $conn;

    public function __construct(Database $database)
    {
        $this->conn = $database->get_connection();
    }

    public function getCartItemsByUser($userId)
    {
        try
        {
            $sql = "SELECT c.id, c.quantity, c.product_id, p.name, p.price, (p.price * c.quantity) AS total
            FROM cart_items c
            JOIN products p ON c.product_id = p.id
            WHERE c.user_id = :user_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } 
        catch(Exception $e) 
        {
            return false;
        }
    }

    public function getCartItemsByRowID($rowId)
    {
        try
        {
            $sql = "SELECT * FROM cart_items WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id' , $rowId , PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } 
        catch(Exception $e)
        {
            return false;
        }
    }

    public function removeItem($id)
    {
        try
        {
            $sql = "DELETE FROM cart_items WHERE id=:id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id' , $id , PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        }
        catch (Exception $e)
        {
            return false;
        }
    }

    public function updateCart($id , $quantity)
    {
        try
        {
            $sql = "UPDATE cart_items SET quantity = :quantity WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id' , $id , PDO::PARAM_INT);
            $stmt->bindValue(':quantity' , $quantity , PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    public function addToCart($id)
    {
        try {
            $sql = "SELECT id FROM cart_items WHERE user_id = :user_id AND product_id = :product_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
            $stmt->bindValue(':product_id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $item = $stmt->fetch(PDO::FETCH_ASSOC);
        
            if ($item) {
                return false;
            } else {
                $sql = "INSERT INTO cart_items (user_id, product_id, quantity)
                        VALUES (:user_id, :product_id, 1)";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
                $stmt->bindValue(':product_id', $id, PDO::PARAM_INT);
                $stmt->execute();
                return true;
            }
        } 
        catch (Exception $e) 
        {
            return false;
        }
    }
}