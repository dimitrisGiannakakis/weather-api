<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace Tripiko\OpenWeatherMap\Airport;

use Tripiko\OpenWeatherMap\Folder;

class ForecastTest extends \PHPUnit_Framework_TestCase
{
    public $forecast;

    public $params;

    public function setUp()
    {
        $this->forecast = new Forecast('-0.45', '51.47','15 Sep 2014', new Folder());

        $this->forecast->setPath(__DIR__.'/../../../cache/Airports');

        //$this->current_weather = new CurrentWeather('Athens', 'Gr', true);
    }

    public function testGetForecastLive()
    {
        $result = $this->forecast->getForecast();

        print_r($result);
    }
}
