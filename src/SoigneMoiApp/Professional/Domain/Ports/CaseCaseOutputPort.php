<?php

namespace App\SoigneMoiApp\Professional\Domain\Ports;

interface ProfessionalOutputPort {
    public function present(ProfessionalResponse $response);
}

?>
