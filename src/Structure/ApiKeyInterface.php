<?php

namespace App\Structure;

interface ApiKeyInterface 
{
    public function getApiKey(): string;
    
    public function setApiKey(string $apiKey);
}

