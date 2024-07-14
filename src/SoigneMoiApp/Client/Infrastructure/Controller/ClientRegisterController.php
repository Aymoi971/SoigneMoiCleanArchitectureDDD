<?php
namespace App\SoigneMoiApp\Client\Infrastucture\Controller;
use App\SoigneMoiApp\Client\Domain\Ports\ClientPersistenceInterface;
use App\SoigneMoiApp\Client\Infrastucture\Presenter\ClientRegisterPresenter;
use App\SoigneMoiApp\Client\Domain\Usecase\Register\ClientRegister;
use App\SoigneMoiApp\Client\Domain\Usecase\Register\ClientRegisterRequest;


class ClientRegisterController extends ClientBaseController {
    private $ClientPersistenceInterface;
    private $ClientRegisterPresenter;
    private $ClientRegisterUseCase;

    public function __construct(ClientPersistenceInterface $ClientPersistenceInterface, ClientRegisterPresenter $ClientRegisterPresenter) {
        parent::__construct();
        $this->ClientRegisterPresenter = $ClientRegisterPresenter;
        $this->ClientPersistenceInterface = $ClientPersistenceInterface;
        $this->ClientRegisterUseCase = new ClientRegister();
    }

    public function handle($email, $password1, $password2, $nom, $prenom, $address) {
        $ClientRegisterRequest = new ClientRegisterRequest($this->ClientPersistenceInterface,$email, $password1, $password2, $nom, $prenom, $address);
        $this->ClientRegisterUseCase->execute( $ClientRegisterRequest, $this->ClientRegisterPresenter);
    }
}
?>
