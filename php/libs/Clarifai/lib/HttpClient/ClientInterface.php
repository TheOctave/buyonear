<?php

namespace Clarifai\HttpClient;

interface ClientInterface {
    public static function request($method, $relUrl, $headers, $params);
}
?>