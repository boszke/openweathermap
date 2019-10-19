<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Service\CacheService;;
use App\Service\OpenWeatherMapService;
use App\Validator\CityValidator;
use GuzzleHttp\Client;
use Phpfastcache\CacheManager;
use Phpfastcache\Config\ConfigurationOption;

CacheManager::setDefaultConfig(new ConfigurationOption([
    'path' => __DIR__ . '/resources/cache',
]));

$request = new \App\Request\ConsoleCityRequest();
$request->setRequest($argv);

$cityValidator = new CityValidator($request);
try {
    $cityValidator->valid();
} catch (App\Exception\ValidationException $e) {
    exit('Błąd walidacji nazw miast. ' . $e->getMessage());
} catch (Exception $e) {
    exit('Wystąpił nieoczekiwany błąd. ' . $e->getMessage());
}


$owm = new OpenWeatherMapService('fca4a6ca45e91ba8bd09c05d4117ca5c', new Client(), $request, new CacheService(CacheManager::getInstance('files')));
try {
    $citiesWeather = $owm->getCitiesWeather();
} catch (Exception $e) {
    exit($e->getMessage());
}

$rank = new \App\Service\CalculateRank($citiesWeather);
$cities = $rank->sortByRank($rank->calculate());

echo 'Miejsce;Miasto;Wynik końcowy;Temperatura;Wiatr;Wilgotność' . PHP_EOL;
foreach ($cities as $index => $city) {
    echo implode(';', [($index + 1), $city['name'], $city['result'], $city['temp'], $city['wind'], $city['humidity'], $city['dateTime']]) . PHP_EOL;
}