<?php
namespace App\SoigneMoiApp\Client\Domain\UseCase\CreateProcess;

use App\SoigneMoiApp\Client\Domain\Entity\ClientUser;
use App\SoigneMoiApp\Client\Domain\Entity\ClientProcess;
use App\SoigneMoiApp\Client\Domain\Ports\ClientPersistenceInterface;


class ClientCreateProcessRequest {
    public ClientUser $clientUser;
    public ClientProcess $clientProcess;
    public ClientPersistenceInterface $clientPersistenceInterface;
    
    public function __construct(ClientUser $clientUser,ClientProcess $clientProcess,ClientPersistenceInterface $clientPersistenceInterface){
        $this->clientPersistenceInterface = $clientPersistenceInterface;
        $this->clientUser = $clientUser;
        $this->clientProcess = $clientProcess;
    }
}
    
    
