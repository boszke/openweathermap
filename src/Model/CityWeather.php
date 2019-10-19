<?php

namespace App\Model;

class CityWeather
{

    const PARAM_NAME     = 'name';
    const PARAM_TEMP     = 'temp';
    const PARAM_HUMIDITY = 'humidity';
    const PARAM_WIND     = 'wind';

    /** @var int */
    private $id;

    /** @var string */
    private $name;

    /** @var float */
    private $temp;

    /** @var float */
    private $humidity;

    /** @var float */
    private $wind;

    /** @var string */
    private $dateTime;

    public function __construct(array $params)
    {
        $this->id       = (int) $params['id'];
        $this->name     = $params['name'];
        $this->temp     = (float) $params['main']['temp'];
        $this->humidity = (float) $params['main']['humidity'];
        $this->wind     = (float) $params['wind']['speed'];
        $this->dateTime = date('Y-m-d H:i:s');
    }

    public function toArray(): array
    {
        return [
            'id'       => $this->id,
            'name'     => $this->name,
            'temp'     => $this->temp,
            'humidity' => $this->humidity,
            'wind'     => $this->wind,
            'dateTime' => $this->dateTime,
        ];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTemp(): float
    {
        return $this->temp;
    }

    public function getHumidity(): float
    {
        return $this->humidity;
    }

    public function getWind(): float
    {
        return $this->wind;
    }

    public function getDateTime(): string
    {
        return $this->dateTime;
    }
}
