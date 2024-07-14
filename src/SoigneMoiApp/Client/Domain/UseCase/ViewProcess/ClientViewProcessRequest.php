<?php
namespace App\SoigneMoiApp\Client\Domain\UseCase\ViewProcess;

class ClientViewProcessRequest {
    
    public $ClientPersistenceInterface;
    
    public function __construct($ClientPersistenceInterface){
        $this->ClientPersistenceInterface = $ClientPersistenceInterface;
    }
}
    
    
