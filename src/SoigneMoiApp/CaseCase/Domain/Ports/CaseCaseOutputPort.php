<?php

namespace App\SoigneMoiApp\CaseCase\Domain\Ports;

interface CaseCaseOutputPort {
    public function present(CaseCaseResponse $response);
}

?>
