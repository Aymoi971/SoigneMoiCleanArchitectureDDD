<?php

namespace App\SoigneMoiApp\CaseCase\Domain\UseCase\USECASENAME;
// use App\SoigneMoiApp\CaseCase\Domain\Usecase\USECASENAME\CaseCaseUSECASENAMEResponse;
// use App\SoigneMoiApp\CaseCase\Domain\Usecase\USECASENAME\CaseCaseUSECASENAMERequest;
use App\SoigneMoiApp\CaseCase\Domain\Ports\CaseCaseOutputPort;

class CaseCaseUSECASENAME {
    
    public function execute(CaseCaseUSECASENAMERequest $request, CaseCaseOutputPort $outputPort) {
        
        $CaseCaseUSECASENAMEResponse = new CaseCaseUSECASENAMEResponse();

        return $outputPort->present($CaseCaseUSECASENAMEResponse);
    }
}
?>
