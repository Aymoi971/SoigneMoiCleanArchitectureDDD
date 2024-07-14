<?php
// infrastructure/JsonOutputAdapter.php

namespace App\SoigneMoiApp\Client\Infrastucture\Presenter;
use ReflectionObject;
use App\SoigneMoiApp\Client\Domain\Ports\ClientOutputPort;
use App\SoigneMoiApp\Client\Domain\Ports\ClientResponse;

class ClientBasePresenter implements ClientOutputPort {
    private $format;
    
    public function __construct($format = 'array')
    {
        $this->setFormat($format);
    }

    public function present(ClientResponse $response) {
        
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
