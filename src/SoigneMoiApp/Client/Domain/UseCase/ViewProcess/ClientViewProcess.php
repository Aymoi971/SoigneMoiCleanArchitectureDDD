<?php

namespace App\SoigneMoiApp\Client\Domain\UseCase\ViewProcess;
// use App\SoigneMoiApp\Client\Domain\Usecase\ViewProcess\ClientViewProcessResponse;
// use App\SoigneMoiApp\Client\Domain\Usecase\ViewProcess\ClientViewProcessRequest;
use App\SoigneMoiApp\Client\Domain\Ports\ClientOutputPort;

class ClientViewProcess {
    
    public function execute(ClientViewProcessRequest $request, ClientOutputPort $outputPort) {
        
        $ClientViewProcessResponse = new ClientViewProcessResponse();

        return $outputPort->present($ClientViewProcessResponse);
    }
}
?>
