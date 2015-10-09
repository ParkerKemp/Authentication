<?php

class Database {
    private static $instance;
    private $conn;
    
    private function __construct(){
        $conn = new mysqli('localhost', 'root', 'password');
        $this->connect();
    }
    
    public static function getInstance(){
        if(!$this->instance){
            $this->instance = new Database();
        }
        return $this->instance;
    }
    
    private function connect(){
        $query = "USE Authentication";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
    }
}
