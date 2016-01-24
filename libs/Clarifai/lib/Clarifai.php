<?php

namespace Clarifai;

class Clarifai {

	public static $appName;

    public static $apiClientId;
    public static $apiClientSecret;
    public static $apiBase = 'https://api.clarifai.com';
    public static $version = '/v1';

    public static function getAppName() {
        return self::$appName;
    }
    public static function setAppName($appName) {
        self::$appName = $appName;
    }

    public static function getApiClientId() {
        return self::$apiClientId;
    }
    public static function setApiClientId($apiClientId) {
        self::$apiClientId = $apiClientId;
    }


    public static function getApiClientSecret() {
        return self::$apiClientId;
    }
    public static function setApiClientSecret($apiClientSecret) {
        self::$apiClientSecret = $apiClientSecret;
    }

    public static function getApiBase() {
        return self::$apiBase.self::$version;
    }
}
