<?php
namespace App\SoigneMoiApp\Client\Domain\UseCase\Login;

class ClientLoginRequest {
    
    public $clientPersistenceInterface;
    public $email;
    public $password;
    
    public function __construct($clientPersistenceInterface, $email, $password) {
        $this->clientPersistenceInterface = $clientPersistenceInterface;
        $this->email = $email;
        $this->password = $password;
    }
}
    
    
