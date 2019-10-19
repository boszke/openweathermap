<?php

namespace App\Service;

use App\Model\CityWeather;
use App\Service\CacheService;
use App\Structure\ApiInterface;
use App\Structure\RequestInterface;
use GuzzleHttp\ClientInterface;

class OpenWeatherMapService implements ApiInterface
{

    /** @var string */
    protected $apiKey = '';

    /** @var ClientInterface */
    protected $clientInterface;

    /** @var RequestInterface */
    protected $requestInterface;

    /** @var CacheService */
    protected $cacheInstance;

    public function __construct(string $apiKey, ClientInterface $clientInterface, RequestInterface $requestInterface, CacheService $cacheInstance = null)
    {
        $this->apiKey           = $apiKey;
        $this->clientInterface  = $clientInterface;
        $this->requestInterface = $requestInterface;
        $this->cacheInstance    = $cacheInstance;
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    public function setApiKey(string $apiKey)
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * 
     * @return array|CityWeather[]
     */
    public function getCitiesWeather(): array
    {
        $citiesWeather = [];
        foreach ($this->requestInterface->getRequest() as $cityName) {
            $cached = $this->cacheInstance->getCache($cityName);
            if ($cached !== null) {
                $citiesWeather[$cityName] = $cached;
                continue;
            }
            $response = $this->clientInterface->request('GET', 'api.openweathermap.org/data/2.5/weather?' . http_build_query(['q' => $cityName, 'appid' => $this->getApiKey(), 'units' => 'metric']));

            $cityWeather = new CityWeather(json_decode($response->getBody()->getContents(), true));
            $this->cacheInstance->setCache($cityName, $cityWeather);
            
            $citiesWeather[$cityName] = $cityWeather;
        }
        
        return $citiesWeather;
    }

}
