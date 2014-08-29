<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace Tripiko\OpenWeatherMap\CurrentWeather;

use Tripiko\OpenWeatherMap\OpenWeatherMap;
use Tripiko\OpenWeatherMap\StorageInterface;
/**
 *
 **/
class CurrentWeather extends OpenWeatherMap
{
    private $city;

    private $country;

    private $weatherUrl = "http://api.openweathermap.org/data/2.5/forecast?";

    private $cached;

    private $storage;

    const MODE = 'json';

    const LANG = 'en';

    const TYPE = 'accurate';

	const UNIT = 'metric';

    public function __construct($query, $t2, StorageInterface $storage)
    {
        $this->city = $query;

        $this->country = $t2;

        $this->storage = $storage;
    }

    private function setParams()
    {
        $params = 'q='.$this->city.','.$this->country;

        return $params;
    }


    public function createQuery()
    {
        $params  = $this->setParams();
        $url = $this->weatherUrl.$params.'&units='.self::UNIT.'&type='.self::TYPE.'&lang='.self::LANG.'&mode='.self::MODE;

        return $url;
    }


    public function getCurrentWeather()
    {

        $file = $this->country.'_'.$this->city.'_'.date('Y-m-d');

        $data = $this->storage->readThe($file);

        if (!isset($data)) {

            $q = $this->createQuery();

            $response = $this->get($q);

            print_r($response);

            $this->storage->saveThe($response);

            return $response;

        } else {

            $today = strtotime(date('Y-m-d H:i:s'));
            foreach($data->list as $key => $value) {

                $cache_day = strtotime($value->dt_txt);

                $diff = ($today - $cache_day)/60;

                if ($diff <= 140  && $diff >= -30) {

                    print_r($value);

                    return $value;
                }
            }

        }


    }

}
