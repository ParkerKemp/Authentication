<?php

class Database {
    private static $instance;
    private $conn;
    
    private function __construct(){
        $this->conn = new mysqli('localhost', 'root', 'password');
        $this->connect();
    }
    
    public static function getInstance(){
        if(!static::$instance){
            static::$instance = new Database();
        }
        return static::$instance;
    }
    
    private function connect(){
        $this->conn->select_db('Authentication');
    }
    
    public function prepare($query){
        return $this->conn->prepare($query);
    }
    
    public function lastError(){
        echo $this->conn->error;
    }
}
