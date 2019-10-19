<?php

namespace App\Service;

use App\Model\CityWeather;

class CalculateRank
{

    const PARAM_TO_MODIFIER = [
        CityWeather::PARAM_TEMP     => ['modifier' => 0.6, 'type' => 'desc'],
        CityWeather::PARAM_WIND     => ['modifier' => 0.3, 'type' => 'desc'],
        CityWeather::PARAM_HUMIDITY => ['modifier' => 0.1, 'type' => 'asc'],
    ];

    /** @var array|CityWeather[] */
    private $citiesWeather;

    public function __construct(array $citiesWeather)
    {
        $this->citiesWeather = $citiesWeather;
    }

    public function calculate(): array
    {
        $citiesWeather = array_map(static function (CityWeather $cityWeather) {
            return $cityWeather->toArray();
        }, $this->citiesWeather);
        foreach (self::PARAM_TO_MODIFIER as $paramKey => $paramsOptions) {
            usort($citiesWeather, function(array $a, array $b) use($paramKey, $paramsOptions) {
                return $paramsOptions['type'] === 'desc' ? $a[$paramKey] <=> $b[$paramKey] : $b[$paramKey] <=> $a[$paramKey];
            });
            foreach ($citiesWeather as $index => &$cityWeather) {
                if (!isset($cityWeather['result'])) {
                    $cityWeather['result'] = 0;
                }
                $cityWeather['result'] += ((100 - 10 * (($index + 1) - 1)) * $paramsOptions['modifier']);
            }
            unset($cityWeather);
        }

        return $citiesWeather;
    }

    public function sortByRank(array $citiesWeather)
    {
        usort($citiesWeather, function(array $a, array $b) {
            return $b['result'] <=> $a['result'];
        });
        
        return $citiesWeather;
    }

}
