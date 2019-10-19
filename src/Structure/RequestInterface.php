<?php

namespace App\Structure;

interface RequestInterface
{
    public function setRequest(array $data);
            
    public function getRequest(): array;
}