<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace Tripiko\OpenWeatherMap;

use Tripiko\OpenWeatherMap\StorageInterface;
use Tripiko\OpenWeatherMap\OpenWeatherMap;

class Request extends OpenWeatherMap
{
    public $city;

    public $country;

    protected $weather_url;

    protected $cached;

    protected $storage;

    protected $path;

    public $temp;

    public $icon;

    const MODE = 'json';

    const LANG = 'en';

    const TYPE = 'accurate';

	const UNIT = 'metric';

    public function __construct (
        $city,
        $country = null,
        StorageInterface $storage
    ) {
        $this->city = $city;

        $this->country = $country;

        $this->storage = $storage;

    }

    public function setUrl($url)
    {
        $this->weather_url = $url;
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

        $url = $this->weather_url.$params.'&units='.self::UNIT.'&type='.self::TYPE.'&lang='.self::LANG.'&mode='.self::MODE;

        return $url;
    }

}
