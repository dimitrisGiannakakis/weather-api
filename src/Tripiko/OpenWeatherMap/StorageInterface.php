<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace Tripiko\OpenWeatherMap;

interface StorageInterface
{

    public function saveThe($storage);

    public function readThe ($storage);
}

