<?php
namespace App\SoigneMoiApp\Client\Infrastucture\Controller;
use App\SoigneMoiApp\Client\Domain\Ports\ClientPersistenceInterface;
use App\SoigneMoiApp\Client\Infrastucture\Presenter\ClientLoginPresenter;
use App\SoigneMoiApp\Client\Domain\Usecase\Login\ClientLogin;
use App\SoigneMoiApp\Client\Domain\Usecase\Login\ClientLoginRequest;


class ClientLoginController extends ClientBaseController {
    private $ClientPersistenceInterface;
    private $ClientLoginPresenter;
    private $ClientLoginUseCase;

    public function __construct(ClientPersistenceInterface $ClientPersistenceInterface, ClientLoginPresenter $ClientLoginPresenter) {
        parent::__construct();
        $this->ClientLoginPresenter = $ClientLoginPresenter;
        $this->ClientPersistenceInterface = $ClientPersistenceInterface;
        $this->ClientLoginUseCase = new ClientLogin();
    }

    public function handle($email, $password) {
        $ClientLoginRequest = new ClientLoginRequest($this->ClientPersistenceInterface, $email, $password);
        $this->ClientLoginUseCase->execute( $ClientLoginRequest, $this->ClientLoginPresenter);
    }
}
?>
