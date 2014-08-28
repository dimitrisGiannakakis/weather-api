<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace Tripiko\OpenWeatherMap;

use Tripiko\OpenWeatherMap\StorageInterface;

/**
 *
 **/
class Folder implements StorageInterface
{

    public function saveThe($data)
    {
        file_put_contents(__DIR__ . '/cache/'.$data['sys']['country'].'_'.$data['name'].'_'.date('d_m_y_h').'.json', json_encode($data));
    }

    public function readThe($file)
    {
        $jsonurl = __DIR__ . '/cache/'.$file.'.json';

        if (file_exists($jsonurl)) {

            $json = file_get_contents($jsonurl, 0, null, null);

            return json_decode($json);

        } else {

            return null;
        }
    }

}

