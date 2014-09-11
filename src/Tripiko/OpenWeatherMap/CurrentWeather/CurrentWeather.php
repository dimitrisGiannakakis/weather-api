<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace Tripiko\OpenWeatherMap\CurrentWeather;

use Tripiko\OpenWeatherMap\OpenWeatherMap;
use Tripiko\OpenWeatherMap\StorageInterface;
use Tripiko\OpenWeatherMap\Request;

class CurrentWeather extends Request
{
    public $city;

    public $country;

    public $temp;

    public $icon;

    protected $cached;

    protected $storage;

    public function __construct (
        $city,
        $country = null,
        StorageInterface $storage
    ) {
    $this->city = $city;

    $this->country = $country;

    $this->storage = $storage;

    }
    public function getCurrentWeather()
    {
        $file = $this->country.'_'.$this->city;

        $data = $this->storage->readThe($this->path, $file);

        if (!isset($data)) {

            $this->setUrl('http://api.openweathermap.org/data/2.5/forecast?');

            $params = $this->createParams();

            $this->setParams($params);

            $q = $this->createQuery();

            $response = $this->get($q);

            $file_name = $response['city']['country'].'_'.$response['city']['name'];

            $data = $this->storage->saveThe($this->getPath(), $file_name,  $response);

            $after_save = json_decode($data);

            $today = strtotime(date('Y-m-d H:i:s'));

            //$today =  strtotime(date('2014-09-01 20:32:00'));

            $result = $this->find_entry($after_save);

            return $result;

        } else {

            $result = $this->find_entry($data);

            return $result;

            //$today =  strtotime(date('2014-09-01 20:32:00'));
        }
    }

    private function createParams()
    {
        $params = 'q='.$this->city.','.$this->country;

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

    private function find_entry($data)
    {
        $today = strtotime(date('Y-m-d H:i:s'));

        foreach($data->list as $key => $value) {

            $cache_day = strtotime($value->dt_txt);

            $diff = ($today - $cache_day)/60;

            if ($diff <= 150  && $diff >= -30) {

                $this->setTemp($value);

                $this->setIcon($value);

                return $this;
            }
        }
    }
}
