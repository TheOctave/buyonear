<?php
include 'config.php';

$url = isset($_GET['url']) ? $_GET['url'] : 'error';
$url = rtrim($url, '/');
$urlArray = explode("/", $url);

if ($urlArray[0] == 'register') {
    
    include 'controls/register/index.php';
} else if ($urlArray[0] == 'products') {
    
	if (!isset($urlArray[1]) ) {
		
		include 'controls/products/index.php';
		die;
	} else if (isset($urlArray[2])) {
		
		if ($urlArray[2] == "rate") {
			include 'controls/products/rate.php';
		} else if ($urlArray[2] == "bid"){
			include 'controls/products/bid.php';
		} else {
			basicFailureStatus();
		}
		die;
	}
} else if ($urlArray[0] == 'profile') {
    
    include 'controls/product.php';
}else if ($urlArray[0] == 'search') {
 
    include 'controls/search.php';
} else {
	
	//Error page
}

function basicFailureStatus() {
	
	$result = array('status' => 'failure');
	echo json_encode($result);
	die;
}