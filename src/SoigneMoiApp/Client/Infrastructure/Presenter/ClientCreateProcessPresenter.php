<?php

namespace App\SoigneMoiApp\Client\Infrastucture\Presenter;
use App\SoigneMoiApp\Client\Domain\Ports\ClientResponse;

class CreateProcessPresenter extends ClientBasePresenter{
    public function present(ClientResponse $response) {
        return $response;
    }
}
?>