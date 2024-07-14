<?php

namespace App\SoigneMoiApp\Staff\Domain\Usecase\USECASENAME;
// use App\SoigneMoiApp\Staff\Domain\Usecase\USECASENAME\StaffUSECASENAMEResponse;
// use App\SoigneMoiApp\Staff\Domain\Usecase\USECASENAME\StaffUSECASENAMERequest;
use App\SoigneMoiApp\Staff\Domain\Ports\StaffOutputPort;

class StaffUSECASENAME {
    
    public function execute(StaffUSECASENAMERequest $request, StaffOutputPort $outputPort) {
        
        $StaffUSECASENAMEResponse = new StaffUSECASENAMEResponse();

        return $outputPort->present($StaffUSECASENAMEResponse);
    }
}
?>
