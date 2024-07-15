<?php

namespace App\SoigneMoiApp\Client\Domain\UseCase\CreateProcess;
use App\SoigneMoiApp\Client\Domain\Entity\ClientUser;
use App\SoigneMoiApp\Client\Domain\Entity\ClientProcess;
// use App\SoigneMoiApp\Client\Domain\Usecase\CreateProcess\ClientCreateProcessRequest;
use App\SoigneMoiApp\Client\Domain\Ports\ClientOutputPort;

class ClientCreateProcess {
    
    public function execute(ClientCreateProcessRequest $request, ClientOutputPort $outputPort) {
        $user = $request->clientUser;
        $response = new ClientCreateProcessResponse();

        if (!$user->isAuthorized('Create_Process_Self')){
            $response->status = "failure";
            $response->message = "Not_Authorized";
            return $outputPort->present($response);
        }
        $persistence = $request->clientPersistenceInterface;
        if (!$persistence->isLoggedIn($user)){
            $response->status = "failure";
            $response->message = "Not_Logged_In";
            return $outputPort->present($response);
        }
        $process = $request->clientProcess;
        if ($process->getErrors()){
            $response->status = "failure";
            $response->message = "Incomplete_Data";
            $response->errors = $process->getErrors();
            return $outputPort->present($response);
        }
        
        $persistence->addClientProcess($user, $process);
        $response->status = "success";
        $response->message = "Process_added";
        $response->clientProcess = $process;
        return $outputPort->present($response);
    }
                
            
        
       
    
}
?>
