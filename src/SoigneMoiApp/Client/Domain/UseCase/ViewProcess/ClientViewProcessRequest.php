<?php
namespace App\SoigneMoiApp\Client\Domain\UseCase\ViewProcess;

class ClientViewProcessRequest {
    
    public $clientPersistenceInterface;
    public $email;
    
    public function __construct($email,$clientPersistenceInterface){
        $this->clientPersistenceInterface = $clientPersistenceInterface;
    }
}
    
    
