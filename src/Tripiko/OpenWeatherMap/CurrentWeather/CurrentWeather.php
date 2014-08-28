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

    private $weatherUrl = "http://api.openweathermap.org/data/2.5/weather?";

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
       // $this->country = $query['country'];
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

        print_r($url);

        if (!empty($appid)) {
               // $url .= '&APPID='.$this->appid['appid'];
        }

        return $url;
    }


    public function getCurrentWeather()
    {

        $file = $this->country.'_'.$this->city.'_'.date('d_m_y_h');

        $data = $this->storage->readThe($file);

        if (!isset($data)) {

            $q = $this->createQuery();

            $response = $this->get($q);

            $this->storage->saveThe($response);

            //echo'-------.............RESPONSE-----------------------'.PHP_EOL;
            //print_r($json_response);

        } else {

            $response = $data;
        }

        return $response;

    }

}
