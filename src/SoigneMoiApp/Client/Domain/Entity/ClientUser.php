<?php
namespace App\SoigneMoiApp\Client\Domain\Entity;
use App\SoigneMoiApp\Client\Domain\Ports\ClientPersistenceInterface;
use DateTime;

class ClientUser {
    private $email;
    private $rightsArray;
    private $processesArray;
    public $profile;

    public function __construct($email = null, $rightsArray = [], $processesArray = [],$nom = null, $prenom = null, $address = null) {
        $this->rightsArray = $rightsArray;
        $this->processesArray = $processesArray;
        $this->email = $email;
        $this->profile = new ClientProfile($nom, $prenom, $address);
    }

    public function isAuthorized($right):bool{
        return in_array($right, $this->rightsArray);
    }

    private function hasRoomForProcess(ClientProcess $process){
        $newStartDate = new DateTime($process->getStartDate());
        $newEndDate = new DateTime($process->getEndDate());

        foreach ($this->processesArray as $existingProcess) {
            $existingStartDate = new DateTime($existingProcess->startDate);
            $existingEndDate = new DateTime($existingProcess->endDate);

            // Check for overlap
            if ($newStartDate <= $existingEndDate && $newEndDate >= $existingStartDate) {
                return false;
            }
        }

        return true;
    }
    public function addProcess(ClientProcess $process){
        if ($this->hasRoomForProcess($process)) {
            $this->processesArray[] = $process;
            return true;
        }
        return false;
    }
    public function __toString() {
        return "User(email={$this->email}), rightsArray={$this->rightsArray}, processesArray={$this->processesArray})";
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of rightsArray
     */ 
    public function getRightsArray()
    {
        return $this->rightsArray;
    }

    /**
     * Set the value of rightsArray
     *
     * @return  self
     */ 
    public function setRightsArray($rightsArray)
    {
        $this->rightsArray = $rightsArray;

        return $this;
    }

    /**
     * Get the value of processesArray
     */ 
    public function getProcessesArray()
    {
        return $this->processesArray;
    }

    /**
     * Set the value of processesArray
     *
     * @return  self
     */ 
    public function setProcessesArray($processesArray)
    {
        $this->processesArray = $processesArray;

        return $this;
    }
}
?>
