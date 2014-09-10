<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace Tripiko\OpenWeatherMap\CurrentWeather;

use Tripiko\OpenWeatherMap\MemCache;
/**
 *
 **/
class CurrentWeatherMemCacheTest extends \PHPUnit_Framework_TestCase
{
    public $current_weather;

    public $params;

    public function setUp()
    {
        $this->current_weather = new CurrentWeather('Athens', 'GR', new MemCache());
        //$this->current_weather = new CurrentWeather('Athens', 'Gr', true);
    }

    public function testGetCurrentWeatherLive()
    {
        $this->current_weather->getCurrentWeather();
    }
}
