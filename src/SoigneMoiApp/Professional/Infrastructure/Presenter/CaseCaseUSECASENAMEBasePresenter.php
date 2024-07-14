<?php
// infrastructure/JsonOutputAdapter.php

namespace App\SoigneMoiApp\Professional\Infrastucture\Presenter;
use ReflectionObject;
use App\SoigneMoiApp\Professional\Domain\Ports\ProfessionalOutputPort;

class ProfessionalBasePresenter implements ProfessionalOutputPort {
    private $format;
    
    public function __construct($format = 'array')
    {
        $this->setFormat($format);
    }

    public function present($response) {
        
        //This is where you create the VIeuw model the output adapter is the ptresenter
    }
    public function adapt($response) {
    
        $reflection = new ReflectionObject($response);
        $properties = $reflection->getProperties();
        $data = [];
    
        foreach ($properties as $property) {
            $property->setAccessible(true);
            $value = $property->getValue($response);

            if (is_object($value)) {
                $data[$property->getName()] = $this->adapt($value);
            } else {
                $data[$property->getName()] = $value;
            }
        }
    
        if ($this->format === 'json') {
            return json_encode($data);
        } else {
            return $data;
        }
        
    }

    /**
     * Get the value of format
     */ 
    public function getFormat()    {
        return $this->format;
    }

    /**
     * Set the value of format
     *
     * @return  self
     */ 
    public function setFormat($format)    {
        $this->format = $format;

        return $this;
    }
}
?>
