<?php
namespace App\SoigneMoiApp\CaseCase\Infrastucture\Controller;
use App\SoigneMoiApp\CaseCase\Domain\Ports\CaseCasePersistenceInterface;
use App\SoigneMoiApp\CaseCase\Infrastucture\Presenter\CaseCaseUSECASENAMEPresenter;
use App\SoigneMoiApp\CaseCase\Domain\Usecase\USECASENAME\CaseCaseUSECASENAME;
use App\SoigneMoiApp\CaseCase\Domain\Usecase\USECASENAME\CaseCaseUSECASENAMERequest;


class CaseCaseUSECASENAMEController extends CaseCaseBaseController {
    private $CaseCasePersistenceInterface;
    private $CaseCaseUSECASENAMEPresenter;
    private $CaseCaseUSECASENAMEUseCase;

    public function __construct(CaseCasePersistenceInterface $CaseCasePersistenceInterface, CaseCaseUSECASENAMEPresenter $CaseCaseUSECASENAMEPresenter) {
        parent::__construct();
        $this->CaseCaseUSECASENAMEPresenter = $CaseCaseUSECASENAMEPresenter;
        $this->CaseCasePersistenceInterface = $CaseCasePersistenceInterface;
        $this->CaseCaseUSECASENAMEUseCase = new CaseCaseUSECASENAME();
    }

    public function handle() {
        $CaseCaseUSECASENAMERequest = new CaseCaseUSECASENAMERequest($this->CaseCasePersistenceInterface);
        $this->CaseCaseUSECASENAMEUseCase->execute( $CaseCaseUSECASENAMERequest, $this->CaseCaseUSECASENAMEPresenter);
    }
}
?>
