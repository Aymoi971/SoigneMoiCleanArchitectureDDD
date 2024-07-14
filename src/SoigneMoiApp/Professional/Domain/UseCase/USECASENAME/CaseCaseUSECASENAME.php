<?php

namespace App\SoigneMoiApp\Professional\Domain\Usecase\USECASENAME;
// use App\SoigneMoiApp\Professional\Domain\Usecase\USECASENAME\ProfessionalUSECASENAMEResponse;
// use App\SoigneMoiApp\Professional\Domain\Usecase\USECASENAME\ProfessionalUSECASENAMERequest;
use App\SoigneMoiApp\Professional\Domain\Ports\ProfessionalOutputPort;

class ProfessionalUSECASENAME {
    
    public function execute(ProfessionalUSECASENAMERequest $request, ProfessionalOutputPort $outputPort) {
        
        $ProfessionalUSECASENAMEResponse = new ProfessionalUSECASENAMEResponse();

        return $outputPort->present($ProfessionalUSECASENAMEResponse);
    }
}
?>
