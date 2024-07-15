<?php

namespace App\SoigneMoiApp\Client\Domain\UseCase\ViewProcess;
// use App\SoigneMoiApp\Client\Domain\Usecase\ViewProcess\ClientViewProcessResponse;
// use App\SoigneMoiApp\Client\Domain\Usecase\ViewProcess\ClientViewProcessRequest;
use App\SoigneMoiApp\Client\Domain\Ports\ClientOutputPort;

class ClientViewProcess {
    
    public function execute(ClientViewProcessRequest $request, ClientOutputPort $outputPort) {
        
        $persistence = $request->clientPersistenceInterface;
        $clientUser = $persistence->getClientUser($request->email);
        $response = new ClientViewProcessResponse();

        if (!$clientUser) {
            $response->status = "failure";
            $response->message = "User_not_found";
            return $outputPort->present($response);
        }
        if (!$clientUser->isAuthorized('View_Process_Self')){
            $response->status = "failure";
            $response->message = "Not_authorized";
            return $outputPort->present($response);
        }
        if (!$persistence->isLoggedIn($clientUser)){
            $response->status = "failure";
            $response->message = "Not_Logged_In";
            return $outputPort->present($response);
        }
        
        $response->status = "success";
        $response->message = "Processes_Retrieved";
        $response->processArr = $clientUser->processesArray;

        return $outputPort->present($response);

    }
}   
?>
