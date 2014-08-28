<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace Tripiko\OpenWeatherMap;

use GuzzleHttp\Client;
use Tripiko\OpenWeatherMap\CurrentWeather\CurrentWeather;
use GuzzleHttp\Stream;
/**
 *
 **/
class OpenWeatherMap
{

	public function get($request)
	{
		$this->client = new Client();

		$this->res = $this->client->get($request, [
			'headers' => [
				'GET' => '/HTTP/1.0',
				'Host' => 'http://api.openweathermap.org/',
				'Content-type' => 'text/html',
				'Content-length' => strlen($request),
			],
        ]);

        $response = $this->getRawResponse();

        return $response;
    }

	private function getRawResponse()
	{
        $result = $this->res->json();

        return $result;
    }


}
