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

    public $temp;

    public $icon;

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

            $data = $this->storage->saveThe($this->path, $response);

            $after_save = json_decode($data);

            $today = strtotime(date('Y-m-d H:i:s'));

            //$today =  strtotime(date('2014-09-01 20:32:00'));

            $result = $this->find_entry($after_save);

            return $result;

            //$this->setIcon();

        } else {

            $result = $this->find_entry($data);

            return $result;

            //$today =  strtotime(date('2014-09-01 20:32:00'));

        }

    }

    public function setTemp($response)
    {
        $this->temp = round($response->main->temp_min);
    }

    public function setIcon($response)
    {
        $this->icon = $response->weather['0']->icon;
    }

    private function find_entry($data)
    {
        $today = strtotime(date('Y-m-d H:i:s'));

        foreach($data->list as $key => $value) {

            $cache_day = strtotime($value->dt_txt);

            $diff = ($today - $cache_day)/60;


            if ($diff <= 150  && $diff >= -30) {

                $this->setTemp($value);


                $this->setIcon($value);

                //$this->setIcon();
                return $this;
            }
        }
    }

}
