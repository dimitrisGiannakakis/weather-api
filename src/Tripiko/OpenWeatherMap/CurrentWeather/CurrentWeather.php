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

    private $path;

    const MODE = 'json';

    const LANG = 'en';

    const TYPE = 'accurate';

	const UNIT = 'metric';

    public function __construct($city, $country = null, StorageInterface $storage)
    {
        $this->city = $city;

        $this->country = $country;

        $this->storage = $storage;
    }

    public function setPath($path)
    {
        $this->path = $path;
    }

    public function getPath()
    {
        return $this->path;
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

        $data = $this->storage->readThe($this->path, $file);

        if (!isset($data)) {

            $q = $this->createQuery();

            $response = $this->get($q);

            $this->storage->saveThe($this->path, $response);

            return $response;

        } else {

            $today = strtotime(date('Y-m-d H:i:s'));

            //$today =  strtotime(date('2014-08-29 15:01:00'));

            foreach($data->list as $key => $value) {

                $cache_day = strtotime($value->dt_txt);

                $diff = ($today - $cache_day)/60;

                if ($diff <= 140  && $diff >= -30) {

                    return $value;
                }
            }

        }

    }

}
