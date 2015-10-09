<?php

class RegistrationRequest {
    private $accessKey;
    private $publicKey;
    
    public function __construct($accessKey, $publicKey){
        $this->accessKey = $accessKey;
        $this->publicKey = $publicKey;
    }
    
    public function process(){
        
    }
}
