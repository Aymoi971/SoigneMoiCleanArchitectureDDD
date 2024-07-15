<?php
namespace App\SoigneMoiApp\Client\Infrastucture\Controller;
use App\SoigneMoiApp\Client\Domain\Ports\ClientPersistenceInterface;
use App\SoigneMoiApp\Client\Infrastucture\Presenter\ClientViewProcessPresenter;
use App\SoigneMoiApp\Client\Domain\Usecase\ViewProcess\ClientViewProcess;
use App\SoigneMoiApp\Client\Domain\Usecase\ViewProcess\ClientViewProcessRequest;


class ClientViewProcessController extends ClientBaseController {
    private $ClientPersistenceInterface;
    private $ClientViewProcessPresenter;
    private $ClientViewProcessUseCase;

    public function __construct(ClientPersistenceInterface $ClientPersistenceInterface, ClientViewProcessPresenter $ClientViewProcessPresenter) {
        parent::__construct();
        $this->ClientViewProcessPresenter = $ClientViewProcessPresenter;
        $this->ClientPersistenceInterface = $ClientPersistenceInterface;
        $this->ClientViewProcessUseCase = new ClientViewProcess();
    }

    public function handle($email) {
        $ClientViewProcessRequest = new ClientViewProcessRequest($email, $this->ClientPersistenceInterface);
        $this->ClientViewProcessUseCase->execute( $ClientViewProcessRequest, $this->ClientViewProcessPresenter);
    }
}
?>
