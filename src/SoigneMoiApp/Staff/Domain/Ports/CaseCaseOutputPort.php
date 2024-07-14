<?php

namespace App\SoigneMoiApp\Staff\Domain\Ports;

interface StaffOutputPort {
    public function present(StaffResponse $response);
}

?>
