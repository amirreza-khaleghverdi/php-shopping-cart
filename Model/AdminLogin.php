<?php

require_once 'Database.php';

class AdminLogin
{
    private $conn;

    public function __construct(Database $database)
    {
        $this->conn = $database->get_connection();
    }

    public function check_login($username , $password)
    {
        $sql = "SELECT * from admin_users where name = :username LIMIT 1";
        $stmt=$this->conn->prepare($sql);
        $stmt->bindValue(':username' , $username);
        $stmt->execute();
        $user=$stmt->fetch(PDO::FETCH_ASSOC);

        if($user && password_verify($password,$user['password']))
        {
            return $user;
        }
        else
        {
            return false;
        }

    }

    public function register($username,$password)
    {
        try {
            $hash=password_hash($password,PASSWORD_DEFAULT);
            $sql = "INSERT INTO admin_users (name, password) VALUES (:username, :password)";
            $stmt=$this->conn->prepare($sql);
            $stmt->bindValue(':username' , $username);
            $stmt->bindValue(':password' , $hash);
            $stmt->execute();
            
            $id=$this->conn->lastInsertId();

            $sql="SELECT * FROM users WHERE id = :id LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id' , $id, PDO::PARAM_INT);
            $stmt->execute();
            $user=$stmt->fetch(PDO::FETCH_ASSOC);
            return $user;
        } 
        catch (Exception $e) 
        {
            return false;
        }
    }

    public function change_password($user_id, $password)
    {
        try{

            $hash=password_hash($password,PASSWORD_DEFAULT);
            $sql = "UPDATE admin_users SET password =:password WHERE id =:user_id ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindValue(':password' ,$hash);
            $stmt->execute();
            return $stmt;

        }
        catch(Exception $e)
        {
            return false;
        }
    }
}

?>