<?php

namespace Clarifai;

use Clarifai\HttpClient\CurlClient;


class Tag {

    private static $baseUrl = '/tag/';

	public static function retrieve($url, $opts = null)
    {
    	$relUrl = self::$baseUrl;
    	$headers = array();
    	$params = array(
    		"url"			=> $url,
    		"access_token"	=> "XPVPOytJa6f42LXimZcCOz7LArNQLY"
    	);

    	$response = \Clarifai\HttpClient\CurlClient::request('GET', $relUrl, $headers, $params);
    	return $response;
    }
}
?>