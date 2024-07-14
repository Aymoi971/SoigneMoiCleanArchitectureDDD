<?php
namespace App\SoigneMoiApp\Staff\Infrastucture\Controller;
use App\SoigneMoiApp\Staff\Domain\Ports\StaffPersistenceInterface;
use App\SoigneMoiApp\Staff\Infrastucture\Presenter\StaffUSECASENAMEPresenter;
use App\SoigneMoiApp\Staff\Domain\Usecase\USECASENAME\StaffUSECASENAME;
use App\SoigneMoiApp\Staff\Domain\Usecase\USECASENAME\StaffUSECASENAMERequest;


class StaffUSECASENAMEController extends StaffBaseController {
    private $StaffPersistenceInterface;
    private $StaffUSECASENAMEPresenter;
    private $StaffUSECASENAMEUseCase;

    public function __construct(StaffPersistenceInterface $StaffPersistenceInterface, StaffUSECASENAMEPresenter $StaffUSECASENAMEPresenter) {
        parent::__construct();
        $this->StaffUSECASENAMEPresenter = $StaffUSECASENAMEPresenter;
        $this->StaffPersistenceInterface = $StaffPersistenceInterface;
        $this->StaffUSECASENAMEUseCase = new StaffUSECASENAME();
    }

    public function handle() {
        $StaffUSECASENAMERequest = new StaffUSECASENAMERequest($this->StaffPersistenceInterface);
        $this->StaffUSECASENAMEUseCase->execute( $StaffUSECASENAMERequest, $this->StaffUSECASENAMEPresenter);
    }
}
?>
