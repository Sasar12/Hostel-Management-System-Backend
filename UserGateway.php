<?php

class UserGateway
{
    private PDO $conn;
    
    public function __construct(Database $database)
    {
        $this->conn = $database->getConnection();
    }
    
    public function getByAPIKey(string $key): array | false
    {
        $sql = "SELECT *
                FROM user_details
                WHERE api_key = :api_key";
                
        $stmt = $this->conn->prepare($sql);
        
        $stmt->bindValue(":api_key", $key, PDO::PARAM_STR);
        
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getByUsername(string $firstname): array | false
    {
        $sql = "SELECT *
                FROM user_details
                WHERE first_name = :firstname";
                
        $stmt = $this->conn->prepare($sql);
        
        $stmt->bindValue(":username", $firstname, PDO::PARAM_STR);
        
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getByID(int $id): array | false
    {
        $sql = "SELECT *
                FROM user_details
                WHERE user_id = :id";
                
        $stmt = $this->conn->prepare($sql);
        
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}