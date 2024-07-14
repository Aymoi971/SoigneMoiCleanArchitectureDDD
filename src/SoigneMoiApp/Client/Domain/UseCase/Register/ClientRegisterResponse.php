<?php

namespace App\SoigneMoiApp\Client\Domain\UseCase\Register;
use  App\SoigneMoiApp\Client\Domain\Ports\ClientResponse;
use  App\SoigneMoiApp\Client\Domain\Entity\ClientUser;

class ClientRegisterResponse extends ClientResponse  {
    public ClientUser $clientUser;
}