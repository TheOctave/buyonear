<?php
class Config {
	static private $db_username = "root";
	static private $db_password = "swamphacks";
	static private $db_name = "buyonear";
	static private $db_server = "162.243.13.50";

	static private $method_get = "GET";
	static private $method_post = "POST";

	static private $stripe = array(
		"secret_key"      => "sk_test_Bq1aDgp01WpJohk9aAs2M3yZ",
		"publishable_key" => "pk_test_sJTNOAtAu5X2qTHC3f63PmAG"
	);

	static private $clarifai = array(
		"app_name"		=> "Buyoneer",
		"client_id"		=> "yHUC2EMkFtqM-cZnPfnSljjYai7ANPHk8x4_7noU",
		"client_secret"	=> "oHJMI477juh9fJNGvokVeuNwCgv4bfg9FbLSuflX"
	);

	public static function getDBUsername(){
		return self::$db_username;
	}
	public static function getDBPassword(){
		return self::$db_password;
	}
	public static function getDBServer(){
		return self::$db_server;
	}
	public static function getDBName(){
		return self::$db_name;
	}
	public static function getStripeSecret(){
		return self::$stripe["secret_key"];
	}
	public static function getStripePublic(){
		return self::$stripe["publishable_key"];
	}
	public static function getClarifaiAppName(){
		return self::$clarifai["app_name"];
	}
	public static function getClarifaiClientId(){
		return self::$clarifai["client_id"];
	}
	public static function getClarifaiClientSecret(){
		return self::$clarifai["client_secret"];
	}

	public static function GET(){
		return self::$method_get;
	}

	public static function POST(){
		return self::$method_post;
	}
}
?>