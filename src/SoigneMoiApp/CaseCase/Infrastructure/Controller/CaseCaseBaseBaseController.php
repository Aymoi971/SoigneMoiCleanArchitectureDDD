<?php
// controllers/BaseController.php
namespace App\SoigneMoiApp\CaseCase\Infrastucture\Controller;
abstract class CaseCaseBaseController {
    public function __construct() {
        // Common setup if needed
    }

    protected function parseInput($data, $source) {
        if ($source === 'api') {
            return json_decode($data, true);
        } else if ($source === 'web') {
            return $data;
        }
        return [];
    }
}
?>
