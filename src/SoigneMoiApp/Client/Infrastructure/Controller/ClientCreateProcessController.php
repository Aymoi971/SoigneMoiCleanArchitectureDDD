<?php
namespace App\SoigneMoiApp\Client\Infrastucture\Controller;
use App\SoigneMoiApp\Client\Domain\Ports\ClientPersistenceInterface;
use App\SoigneMoiApp\Client\Infrastucture\Presenter\ClientCreateProcessPresenter;
use App\SoigneMoiApp\Client\Domain\Usecase\CreateProcess\ClientCreateProcess;
use App\SoigneMoiApp\Client\Domain\Usecase\CreateProcess\ClientCreateProcessRequest;
use App\SoigneMoiApp\Client\Domain\Entity\ClientUser;
use App\SoigneMoiApp\Client\Domain\Entity\ClientProcess;



class ClientCreateProcessController extends ClientBaseController {
    private $ClientPersistenceInterface;
    private $ClientCreateProcessPresenter;
    private $ClientCreateProcessUseCase;

    public function __construct(ClientPersistenceInterface $ClientPersistenceInterface, ClientCreateProcessPresenter $ClientCreateProcessPresenter) {
        parent::__construct();
        $this->ClientCreateProcessPresenter = $ClientCreateProcessPresenter;
        $this->ClientPersistenceInterface = $ClientPersistenceInterface;
        $this->ClientCreateProcessUseCase = new ClientCreateProcess();
    }

    public function handle(ClientUser $clientUser,ClientProcess $clientProcess) {

        $request = new ClientCreateProcessRequest( $clientUser, $clientProcess, $this->ClientPersistenceInterface);
        $this->ClientCreateProcessUseCase->execute( $request, $this->ClientCreateProcessPresenter);
    }
    
}
?>
