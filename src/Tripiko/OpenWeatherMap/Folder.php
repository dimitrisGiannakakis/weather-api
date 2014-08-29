<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace Tripiko\OpenWeatherMap;

use Tripiko\OpenWeatherMap\StorageInterface;

/**
 *
 **/
class Folder implements StorageInterface
{

    public function saveThe($path, $data)
    {
        file_put_contents(__DIR__.$path.$data['city']['country'].'_'.$data['city']['name'].'_'.date('Y-m-d').'.json', json_encode($data));

    }

    public function readThe($path, $file)
    {
        $jsonurl = __DIR__ .$path.$file.'.json';

        if (file_exists($jsonurl)) {

            $json = file_get_contents($jsonurl, 10, null, null);

            return json_decode($json);

        } else {

            return null;
        }
    }

}

