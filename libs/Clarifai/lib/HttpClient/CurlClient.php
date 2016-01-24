<?php

namespace Clarifai\HttpClient;

use Clarifai\Clarifai;

class CurlClient implements ClientInterface {
	public static function request($method, $relUrl, $headers, $params) {
        $curl = curl_init();
        $baseUrl = \Clarifai\Clarifai::getApiBase();

        $relUrl = $baseUrl.$relUrl;
        $method = strtolower($method);
        $opts = array();

        if ($method == 'get') {
            $opts[CURLOPT_HTTPGET] = 1;
            if (count($params) > 0) {
                $encoded = self::encode($params);
                $relUrl = "$relUrl?$encoded";
            }
        } elseif ($method == 'post') {
            $opts[CURLOPT_POST] = 1;
            $opts[CURLOPT_POSTFIELDS] = self::encode($params);
        }

        $relUrl = self::utf8($relUrl);
        $opts[CURLOPT_URL] = $relUrl;
        $opts[CURLOPT_RETURNTRANSFER] = true;
        $opts[CURLOPT_HTTPHEADER] = $headers;
        $opts[CURLOPT_SSL_VERIFYPEER] = false;

        curl_setopt_array($curl, $opts);

        $rbody = curl_exec($curl);
        $rcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        return json_decode($rbody);
    }

    private static function utf8($value) {
        if (is_string($value) && mb_detect_encoding($value, "UTF-8", true) != "UTF-8") {
            return utf8_encode($value);
        } else {
            return $value;
        }
    }

    private static function encode($arr, $prefix = null) {
        if (!is_array($arr)) {
            return $arr;
        }

        $r = array();
        foreach ($arr as $k => $v) {
            if (is_null($v)) {
                continue;
            }

            if ($prefix && $k && !is_int($k)) {
                $k = $prefix."[".$k."]";
            } elseif ($prefix) {
                $k = $prefix."[]";
            }

            if (is_array($v)) {
                $enc = self::encode($v, $k);
                if ($enc) {
                    $r[] = $enc;
                }
            } else {
                $r[] = urlencode($k)."=".urlencode($v);
            }
        }
        return implode("&", $r);
    }
}
?>