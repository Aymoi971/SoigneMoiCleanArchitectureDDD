<?php
namespace App\SoigneMoiApp\Client\Domain\UseCase\Register;
use App\SoigneMoiApp\Client\Domain\Entity\ClientUser;
use App\SoigneMoiApp\Client\Domain\Ports\ClientPersistenceInterface;

class ClientRegisterRequest {
    
    public ClientPersistenceInterface $ClientPersistenceInterface;
    public ClientUser $clientUser;
    public $password1;
    public $password2;
    public $errors = array();
    static Private $CLIENT_RIGHTS_ARR = ['Create_Process_Self', 'View_Process_Self'];
    
    public function __construct(ClientPersistenceInterface $ClientPersistenceInterface, $email, $password1, $password2, $nom, $prenom, $address){
        $this->ClientPersistenceInterface = $ClientPersistenceInterface;
        $this->clientUser =  new ClientUser($email,$this::$CLIENT_RIGHTS_ARR,[], $nom, $prenom, $address);
        $this->password1 = $password1;
        $this->password2 = $password2;
        $this->setErrors();
    }

    public function setErrors(){
        if($this->clientUser->getEmail() === null) $this->errors['email'] = "Email_Required";
        if($this->password1 === null) $this->errors['password1'] = "Password_Required";
        if($this->password2 === null) $this->errors['password2'] = "Confirm_Password_Required";
        if($this->clientUser->profile->nom === null) $this->errors['nom'] = "Nom_Required";
        if($this->clientUser->profile->prenom === null) $this->errors['prenom'] = "Prenom_Required";
        if($this->clientUser->profile->address === null) $this->errors['address'] = "Address_Required";
        if($this->password1!== $this->password2) $this->errors['password2'] = "Passwords_Must_Match";
    }
}
    
    
