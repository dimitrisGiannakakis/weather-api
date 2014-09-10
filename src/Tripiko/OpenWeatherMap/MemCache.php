<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace Tripiko\OpenWeatherMap;

use Tripiko\OpenWeatherMap\StorageInterface;
use Tripiko\OpenWeatherMap\MemCache\CacheMemCache;

class MemCache  extends CacheMemCache implements StorageInterface
{

    public function readThe($file)
    {
        $name = __DIR__ . '/cache/'.$file;

        $data = $this->getData($name);

        return $data;
    }

    public function saveThe($data)
    {
        $name = __DIR__ . '/cache/'.$data['sys']['country'].'_'.$data['name'].'_'.date('d_m_y_h');

        $this->setData($name, json_encode($data));
    }

}
