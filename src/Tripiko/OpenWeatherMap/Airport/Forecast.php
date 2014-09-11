<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
namespace Tripiko\OpenWeatherMap\Airport;
use Tripiko\OpenWeatherMap\OpenWeatherMap;
use Tripiko\OpenWeatherMap\StorageInterface;
use Tripiko\OpenWeatherMap\Request;
/**
 *
 **/
class Forecast extends Request
{
    public $lon;

    public $lat;

    protected $cached;

    protected $storage;

    const CNT = 10;

    public function __construct (
        $lat,
        $lon,
        StorageInterface $storage
    ) {
    $this->lon = number_format($lon, 2);

    $this->lat = number_format($lat, 2);

    $this->storage = $storage;

    }

    public function getForecast()
    {

        $file = $this->lon.'_'.$this->lat;

        $data = $this->storage->readThe($this->getPath(), $file);

        if (!isset($data)) {

            $this->setUrl('http://api.openweathermap.org/data/2.5/forecast/daily?');

            $params = $this->createParams();

            $this->setParams($params);

            $q = $this->createQuery();

            $response = $this->get($q);

            $path = $this->path;

            $file_name = $this->lon.'_'.$this->lat;

            $data = $this->storage->saveThe($path, $file_name,  $response);

            $after_save = json_decode($data);

            //$today =  strtotime(date('2014-09-01 20:32:00'));

            $result = $this->get_data($after_save);

            return $result;

        } else {

            $result = $this->get_data($data);

            return $result;

            //$today =  strtotime(date('2014-09-01 20:32:00'));
        }
    }

    private function createParams()
    {
        $params = 'lat='.$this->lat.'&lon='.$this->lon.'&cnt='.self::CNT;

        return $params;
    }

    public function setTemp($response)
    {
        $this->temp = round($response->main->temp_min);
    }

    public function setIcon($response)
    {
        $this->icon = $response->weather['0']->icon;
    }

    private function get_data($data)
    {
        $today = date('Y-m-d');

        foreach($data->list as $key => $value) {


            $cache_day = date('Y-m-d',$value->dt);

            if ($today == $cache_day) {

                return $value;
            }
        }
    }

}

