<?php

namespace App\Validator;

use App\Request\ConsoleCityRequest;
use App\Structure\ValidatorInterface;

class CityValidator implements ValidatorInterface
{
    private $request;
    
    public function __construct(ConsoleCityRequest $request)
    {
        $this->request = $request;
    }
    
    public function valid()
    {
        $citiesCount = count($this->request->getRequest());
        if ($citiesCount < 2 || $citiesCount > 4) {
            throw new \App\Exception\ValidationException('Musisz podać 2, 3 lub 4 nazwy miast!');
        }
    }

}
