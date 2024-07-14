<?php

namespace App\SoigneMoiApp\Client\Domain\Ports;
use App\SoigneMoiApp\Client\Domain\Entity\ClientUser;
use App\SoigneMoiApp\Client\Domain\Entity\ClientProcess;


interface ClientPersistenceInterface {
    public function getClientUser($email):?ClientUser;
    public function addClientUser(ClientUser $clientUser):bool;
    public function isLoggedIn(ClientUser $clientUser):bool;
    public function authenticate($email, $password):bool;
    // public function isAuthorized($email,$right):bool;
    // public function getClientProcess(ClientUser $clientUser):?ClientProcess;
    public function addClientProcess(ClientUser $clientUser, ClientProcess $clientProcess):bool;
    public function setClientProcess(ClientUser $clientUser):bool;
}
