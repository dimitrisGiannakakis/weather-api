<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace Tripiko\OpenWeatherMap\MemCache;

/**
 *
 **/
class CacheMemCache
{

    protected $life = 600; // Time To Live

    protected $enabled = false; // Memcache enabled?

    protected $cache = null;



    // constructor

    protected function CacheMemcache() {

        if (class_exists('Memcache')) {

            $this->cache = new Memcache();

            $this->enabled = true;

            if (! $this->cache->connect('localhost', 11211))  { // Instead 'localhost' here can be IP

                $this->cache = null;

                $this->enabled = false;

            }

        }

    }


    // get data from cache server

    protected function getData($key) {

        $data = $this->cache->get($key);

        return false === $data ? null : $data;

    }



    // save data to cache server

    protected function setData($key, $data) {

        //Use MEMCACHE_COMPRESSED to store the item compressed (uses zlib).

        return $this->cache->set($key, $data, 0, $this->life);

    }



    // delete data from cache server

    protected function delData($key) {

        return $this->cache->delete($key);

    }
}

