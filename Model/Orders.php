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

            $sql = "SELECT id, total, status, created_at FROM orders WHERE id = :order_id";
            $stmt=$this->conn->prepare($sql);
            $stmt->bindValue(':order_id' , $order_id ,PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);

        }
        catch (Exception $e){
            return false;
        }
    }

    public function confirmOrder($order_id)
    {
        try {
            if (!isset($_SESSION['user_id'])) {
                $_SESSION['error'] = "You must be logged in.";
                return false;
            }
    
            $this->conn->beginTransaction();
    
            // Get order items
            $sql = "SELECT product_id, quantity FROM order_items WHERE order_id = :order_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':order_id', $order_id, PDO::PARAM_INT);
            $stmt->execute();
            $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            if (empty($items)) {
                $this->conn->rollBack();
                $_SESSION['error'] = "No items found for this order.";
                return false;
            }
    
            foreach ($items as $item) {
                $product_id = $item['product_id'];
                $quantity = $item['quantity'];
    
                // Lock row for update
                $sql = "SELECT stock FROM products WHERE id = :product_id FOR UPDATE";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindValue(':product_id', $product_id, PDO::PARAM_INT);
                $stmt->execute();
                $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
                if (!$product || $product['stock'] < $quantity) {
                    $this->conn->rollBack();
                    $_SESSION['error'] = "Not enough stock for product ID: $product_id";
                    return false;
                }
    
                // Reduce stock
                $sql = "UPDATE products SET stock = stock - :quantity WHERE id = :product_id";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindValue(':quantity', $quantity, PDO::PARAM_INT);
                $stmt->bindValue(':product_id', $product_id, PDO::PARAM_INT);
                $stmt->execute();
            }
    
            // Mark order as completed
            $sql = "UPDATE orders SET status = 'completed' WHERE id = :order_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':order_id', $order_id, PDO::PARAM_INT);
            $stmt->execute();
    
            // Clear cart
            $sql = "DELETE FROM cart_items WHERE user_id = :user_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
            $stmt->execute();
    
            $this->conn->commit();
            return true;
    
        } catch (Exception $e) {
            $this->conn->rollBack();
            $_SESSION['error'] = "Transaction failed: " . $e->getMessage();
            return false;
        }
    }

    public function cancelOrder($order_id)
    {
        try{

            $sql = "UPDATE orders SET status = 'cancelled' WHERE id = :order_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':order_id', $order_id, PDO::PARAM_INT);
            $stmt->execute();
            return true;
            
        } catch(Exception $e) {
            return false;
        }
    }

    public function getLatestOrdersByUserId($user_id)
    {
        try {
            $sql = "SELECT id, total, status, created_at
                    FROM orders
                    WHERE user_id = :id
                    ORDER BY created_at DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return false;
        }
    }

    public function getOrderStatsByUserId($user_id)
    {
        try {
            $sql = "SELECT 
                        SUM(status = 'pending') AS pending,
                        SUM(status = 'completed') AS completed,
                        SUM(status = 'cancelled') AS cancelled,
                        COUNT(*) AS total_orders
                    FROM orders
                    WHERE user_id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return false;
        }
    }
}


?>