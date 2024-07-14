<?php
// entities/User.php
namespace App\SoigneMoiApp\Client\Domain\Entity;

class ClientProcess {
    private $startDate;
    private $endDate;
    private $expertise;
    private $description;
    private $preferredProfessional;
    private $errors = []; // their reference number

    public function __construct($startDate = null, $endDate = null, $expertise = null, $description = null, $preferredProfessional = null) {
        $this->startDate = $startDate ?? null;
        $this->endDate = $endDate ?? null;
        $this->expertise = $expertise ?? null;
        $this->description = $description ?? null;
        $this->preferredProfessional = $preferredProfessional ?? null;
        $this->setErrors();
    }

    private function setErrors(){
        if($this->startDate === null) $this->errors['start'] = "Start_Date_Required";
        if($this->endDate === null) $this->errors['end'] = "End_Date_Required";
        if($this->expertise === null) $this->errors['expertise'] = "Expertise_Required";
        if($this->description === null) $this->errors['description'] = "Description_Required";
        if($this->preferredProfessional === null) $this->errors['preferred'] = "Preferred_Professional_Required";
    }
    public function __toString() {
        // return "User(email={$this->email}), address={$this->address})";
    }

    /**
     * Get the value of startDate
     */ 
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set the value of startDate
     *
     * @return  self
     */ 
    public function setStartDate($startDate)
    {
        // $this->errors['start'] = $startDate !== null ? '': "Expertise_Required";
        if($startDate !== null) {
            unset($this->errors['start']);
        } else {
            $this->errors['start'] = "Start_Date_Required";
        }
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get the value of endDate
     */ 
    public function getEndDate()
    {
        
        return $this->endDate;
    }

    /**
     * Set the value of endDate
     *
     * @return  self
     */ 
    public function setEndDate($endDate)
    {
        // $this->errors['end'] = $endDate!== null ? '': "End_Date_Required";
        if($endDate !== null) {
            unset($this->errors['end']);
        } else {
            $this->errors['end'] = "End_Date_Required";
        }
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get the value of expertise
     */ 
    public function getExpertise()
    {
        return $this->expertise;
    }

    /**
     * Set the value of expertise
     *
     * @return  self
     */ 
    public function setExpertise($expertise)
    {
        // $this->errors['expertise'] = $expertise !== null ? '': "Expertise_Required";
        if($expertise !== null) {
            unset($this->errors['expertise']);
        } else {
            $this->errors['expertise'] = "Expertise_Required";
        }
        $this->expertise = $expertise;

        return $this;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription($description)
    {
        // $this->errors['description'] = $description !== null ? '': "Description_Required";
        if($description !== null) {
            unset($this->errors['description']);
        } else {
            $this->errors['description'] = "Description_Required";
        }
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of preferredProfessional
     */ 
    public function getPreferredProfessional()
    {
        return $this->preferredProfessional;
    }

    /**
     * Set the value of preferredProfessional
     *
     * @return  self
     */ 
    public function setPreferredProfessional($preferredProfessional)
    {
        // $this->errors['preferred'] = $preferredProfessional !== null ? '': "Preferred_Professional_Required";
        if($preferredProfessional !== null) {
            unset($this->errors['preferred']);
        } else {
            $this->errors['preferred'] = "Preferred_Professional_Required";
        }
        $this->preferredProfessional = $preferredProfessional;

        return $this;
    }

    /**
     * Get the value of errors
     */ 
    public function getErrors()
    {
        return $this->errors;
    }
}
?>
