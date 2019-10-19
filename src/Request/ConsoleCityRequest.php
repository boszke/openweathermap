<?php

namespace App\Request;

class ConsoleCityRequest implements \App\Structure\RequestInterface
{
    /** @var array */
    protected $data = [];
    
    public function getRequest(): array
    {
        return $this->data;
    }

    public function setRequest(array $data)
    {
        $this->data = array_diff($data, ['index.php']);
        
        return $this;
    }

}
