<?php

// Clarifi singleton
require(dirname(__FILE__) . '/lib/Clarifai.php');


// HttpClient
require(dirname(__FILE__) . '/lib/HttpClient/ClientInterface.php');
require(dirname(__FILE__) . '/lib/HttpClient/CurlClient.php');


// Stripe API Resources
require(dirname(__FILE__) . '/lib/Tag.php');
require(dirname(__FILE__) . '/lib/Feedback.php');
require(dirname(__FILE__) . '/lib/NSFW.php');

?>