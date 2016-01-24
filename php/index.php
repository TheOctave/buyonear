<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
ini_set('default_charset', 'urf-8');

$directory= "/";

$main_path= $_SERVER['DOCUMENT_ROOT'].$directory;
require_once($main_path.'libs/Slim/Slim.php');
require_once($main_path.'libs/Stripe/init.php');
require_once($main_path.'libs/Clarifai/init.php');
require_once($main_path.'libs/Curl/init.php');

\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$app->contentType('text/html; charset=utf-8');


require_once($main_path.'config.php');
require_once($main_path.'libs/functions.php');



require_once($main_path.'model/stdclass.php');
require_once($main_path.'model/product.php');
require_once($main_path.'model/user.php');


require_once($main_path.'router/routes.php');

require_once($main_path.'init.php');
$app->run();
?>
