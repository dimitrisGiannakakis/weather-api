<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace Tripiko\OpenWeatherMap\CurrentWeather;

use Tripiko\OpenWeatherMap\Folder;
/**
 *
 **/
class CurrentWeatherFolderTest extends \PHPUnit_Framework_TestCase
{
    public $current_weather;

    public $params;

    public function setUp()
    {
        $this->current_weather = new CurrentWeather('Athens', 'GR', new Folder());

        $this->current_weather->setPath(__DIR__.'/../../../cache/Weather');

        //$this->current_weather = new CurrentWeather('Athens', 'Gr', true);
    }

    public function testGetCurrentWeatherLive()
    {
        $result = $this->current_weather->getCurrentWeather();

        print_r($result);
    }
}
