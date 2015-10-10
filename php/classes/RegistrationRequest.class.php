<?php

class RegistrationRequest {
    private $accessKey;
    private $username;
    private $password;
    
    public function __construct($username, $password, $accessKey){
        $this->username = $username;
        $this->password = $password;
        $this->accessKey = $accessKey;
    }
    
    public function process(){
        if(!$this->accessKeyIsUnclaimed()){
            echo "Access key could not be found or was already claimed.";
            return;
        }
        $privateKey = openssl_pkey_get_private($_SESSION['priv']);
        $data = pack('H*', $this->password);
        $r = '';
        if(openssl_private_decrypt($data, $r, $privateKey)){
            $this->password = $r;
            $this->insert();
            $this->claimKey();
        }
        else{
            echo 'Failed to decrypt hash';
        }
    }
    
    private function accessKeyIsUnclaimed(){
        $query = "SELECT * FROM accessKeys WHERE accessKey = ? AND claimed = 0";
        $stmt = Database::getInstance()->prepare($query);
        $stmt->bind_param("s", $this->accessKey);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->fetch_assoc())
            return true;
        else
            return false;
    }
    
    private function insert(){
        $query = "INSERT INTO actors (username, secretKey) VALUES (?, ?)";
        $stmt = Database::getInstance()->prepare($query);
        $stmt->bind_param("ss", $this->username, $this->password);
        $stmt->execute();
    }
    
    private function claimKey(){
        $query = "UPDATE accessKeys SET claimed = 1 WHERE accessKey = ?";
        $stmt = Database::getInstance()->prepare($query);
        $stmt->bind_param("s", $this->accessKey);
        $stmt->execute();
    }
}
