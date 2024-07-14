<?php

namespace App\SoigneMoiApp\Client\Domain\UseCase\Register;
// use App\SoigneMoiApp\Client\Domain\Usecase\Register\ClientRegisterResponse;
// use App\SoigneMoiApp\Client\Domain\Usecase\Register\ClientRegisterRequest;
use App\SoigneMoiApp\Client\Domain\Ports\ClientOutputPort;

class ClientRegister {
    
    public function execute(ClientRegisterRequest $request, ClientOutputPort $outputPort) {
        $persistence=$request->ClientPersistenceInterface;
        $response = new ClientRegisterResponse();
        if($persistence->getClientUser($request->clientUser->getEmail())) {
            $response->status = 'failure';
            $response->message = 'Email_exists';
            return $outputPort->present($response);
        }
        if (count($request->errors) > 0) {
            $response->status = 'failure';
            $response->message = 'Incomplete';
            $response->errors = $request->errors;
            return $outputPort->present($response);
        }
        if($persistence->addClientUser($request->clientUser)) {
            $response->status = 'sucess';
            $response->message = 'User_registered';
            return $outputPort->present($response);
        }
    }
}
?>
