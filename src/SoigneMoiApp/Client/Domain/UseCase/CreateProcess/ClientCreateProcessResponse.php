<?php

namespace App\SoigneMoiApp\Client\Domain\UseCase\CreateProcess;
use  App\SoigneMoiApp\Client\Domain\Ports\ClientResponse;
use  App\SoigneMoiApp\Client\Domain\Entity\ClientProcess;

class ClientCreateProcessResponse extends ClientResponse  {
    public ClientProcess $clientProcess;
}