<?php
namespace App\SoigneMoiApp\Professional\Infrastucture\Controller;
use App\SoigneMoiApp\Professional\Domain\Ports\ProfessionalPersistenceInterface;
use App\SoigneMoiApp\Professional\Infrastucture\Presenter\ProfessionalUSECASENAMEPresenter;
use App\SoigneMoiApp\Professional\Domain\Usecase\USECASENAME\ProfessionalUSECASENAME;
use App\SoigneMoiApp\Professional\Domain\Usecase\USECASENAME\ProfessionalUSECASENAMERequest;


class ProfessionalUSECASENAMEController extends ProfessionalBaseController {
    private $ProfessionalPersistenceInterface;
    private $ProfessionalUSECASENAMEPresenter;
    private $ProfessionalUSECASENAMEUseCase;

    public function __construct(ProfessionalPersistenceInterface $ProfessionalPersistenceInterface, ProfessionalUSECASENAMEPresenter $ProfessionalUSECASENAMEPresenter) {
        parent::__construct();
        $this->ProfessionalUSECASENAMEPresenter = $ProfessionalUSECASENAMEPresenter;
        $this->ProfessionalPersistenceInterface = $ProfessionalPersistenceInterface;
        $this->ProfessionalUSECASENAMEUseCase = new ProfessionalUSECASENAME();
    }

    public function handle() {
        $ProfessionalUSECASENAMERequest = new ProfessionalUSECASENAMERequest($this->ProfessionalPersistenceInterface);
        $this->ProfessionalUSECASENAMEUseCase->execute( $ProfessionalUSECASENAMERequest, $this->ProfessionalUSECASENAMEPresenter);
    }
}
?>
