<?php

namespace App\SoigneMoiApp\Client\Domain\Ports;

interface ClientOutputPort {
    public function present(ClientResponse $response);
}

?>
