<?php

namespace App\SoigneMoiApp\Client\Domain\UseCase\Login;
use  App\SoigneMoiApp\Client\Domain\Ports\ClientResponse;
use  App\SoigneMoiApp\Client\Domain\Entity\ClientUser;

class ClientLoginResponse extends ClientResponse  {
    public ClientUser $clientUser;
    
}