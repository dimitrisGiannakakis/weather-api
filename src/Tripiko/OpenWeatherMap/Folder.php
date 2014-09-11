<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace Tripiko\OpenWeatherMap;

use Tripiko\OpenWeatherMap\StorageInterface;

class Folder implements StorageInterface
{

    public function saveThe($path, $file_name,  $data)
    {
        $path = rtrim($path, '/') . '/';

        file_put_contents($path.$file_name.'.json', json_encode($data));

        return json_encode($data);
    }

    public function readThe($path, $file)
    {
        $path = rtrim($path, '/') . '/';

        $jsonurl = $path.$file.'.json';

        if (file_exists($jsonurl)) {

            $json = file_get_contents($jsonurl, 10, null, null);

            return json_decode($json);

        } else {

            return null;
        }
    }
}
