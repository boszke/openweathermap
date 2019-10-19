<?php

namespace App\Structure;

interface ApiInterface extends ApiKeyInterface 
{
    public function getCitiesWeather();
}