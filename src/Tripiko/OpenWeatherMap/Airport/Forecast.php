<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
namespace Tripiko\OpenWeatherMap\Airport;

use Tripiko\OpenWeatherMap\OpenWeatherMap;
use Tripiko\OpenWeatherMap\StorageInterface;
use Tripiko\OpenWeatherMap\Request;

class Forecast extends Request
{
    public $lon;

    public $lat;

    protected $cached;

    protected $flight_date;

    protected $storage;

    public $temp_min;

    public $temp_max;

    public $icon;

    const CNT = 10;

    public function __construct (
        $lat,
        $lon,
        $date,
        StorageInterface $storage
    ) {

    $this->lon = number_format($lon, 2);

    $this->lat = number_format($lat, 2);

    $this->flight_date = $date;

    $this->storage = $storage;

    }

    public function getForecast()
    {

        $file = $this->lon.'_'.$this->lat;

        $data = $this->storage->readThe($this->getPath(), $file);

        if (!isset($data)) {

            $re = $this->get_from_server();

            return $re;

        } else {

            $result = $this->get_data($data);

            if (!isset($result)) {

                $re = $this->get_from_server();

                return $re;

            }

            return  $result;

            //$today =  strtotime(date('2014-09-01 20:32:00'));
        }
    }

    private function createParams()
    {
        $params = 'lat='.$this->lat.'&lon='.$this->lon.'&cnt='.self::CNT;

        return $params;
    }

    private function get_data($data)
    {
        foreach($data->list as $key => $value) {

            $cache_day = date('d M Y',$value->dt);

            $datetime1 = new \DateTime($cache_day);

            $datetime2 = new \ DateTime($this->flight_date);

            $interval = $datetime1->diff($datetime2);

            $inte = $interval->format('%R%a');

            if( $inte < 0 || $inte >= 10 ) {

                return null;
            }

            if ($this->flight_date == $cache_day) {

                $this->setTemp($value);

                $this->setIcon($value);

                return $this;
            }

        }

            return null;
    }

    public function setTemp($response)
    {
        $this->temp_min = round($response->temp->min);

        $this->temp_max = round($response->temp->max);
    }

    public function setIcon($response)
    {
        $this->icon = $response->weather['0']->icon;

    }

    private function get_from_server()
    {
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

    }
}
