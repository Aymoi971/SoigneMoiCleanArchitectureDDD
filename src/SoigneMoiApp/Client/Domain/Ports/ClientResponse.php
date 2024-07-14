<?php
namespace App\SoigneMoiApp\Client\Domain\Ports;

abstract class ClientResponse {
    public $status;
    public $message;
    public $errors;
}