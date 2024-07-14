<?php
// controllers/BaseController.php
namespace App\SoigneMoiApp\Client\Infrastucture\Controller;
abstract class ClientBaseController {
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
