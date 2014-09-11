<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace Tripiko\OpenWeatherMap;

use Tripiko\OpenWeatherMap\StorageInterface;
use Tripiko\OpenWeatherMap\OpenWeatherMap;

class Request extends OpenWeatherMap
{
    protected $weather_url;

    protected $path;

    protected $params;

    const MODE = 'json';

    const LANG = 'en';

    const TYPE = 'accurate';

	const UNIT = 'metric';


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

    public function setParams($params)
    {
        $this->params = $params;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function createQuery()
    {
        $params  = $this->getParams();

        $url = $this->weather_url.$params.'&units='.self::UNIT.'&type='.self::TYPE.'&lang='.self::LANG.'&mode='.self::MODE;

        return $url;
    }

}
