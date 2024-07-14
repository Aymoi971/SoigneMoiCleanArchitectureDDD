<?php

namespace App\SoigneMoiApp\Client\Domain\UseCase\Login;
// use App\SoigneMoiApp\Client\Domain\Usecase\Login\ClientLoginResponse;
// use App\SoigneMoiApp\Client\Domain\Usecase\Login\ClientLoginRequest;
use App\SoigneMoiApp\Client\Domain\Ports\ClientOutputPort;

class ClientLogin {
    
    public function execute(ClientLoginRequest $request, ClientOutputPort $outputPort) {
        $response = new ClientLoginResponse();
        $persistence = $request->clientPersistenceInterface;
        $user = $persistence->getClientUser($request->email);
        // if ($user) {
        //     $response->clientUser = $persistence->getClientUser($request->email);
        // }
        if($user!==null) {
            if($persistence->authenticate($request->email, $request->password)){
                $response->status = "success";
                $response->message = "User_Logged_In";
                return $outputPort->present($response);
            } else {
                $response->status = "failure";
                $response->message = "Invalid_Password";
                return $outputPort->present($response);
            }    
        }
        $response->status = "failure";
        $response->message = "Invalid_Email";
        return $outputPort->present($response);
        
    }
}
?>
