<?php
namespace App\SoigneMoiApp\Client\Domain\Entity;

class ClientProfile {

    public function __construct(
        public $nom,
        public $prenom,
        public $address
    ){}
}