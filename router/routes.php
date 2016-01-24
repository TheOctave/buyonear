<?php

$app->get("/", function() use($app){
});

/*

/search
/product/id   POST
/product/id   GET
/product/id/bid
/product/id/rate
/register
/profile

*/


$app->get("/search/", function() use($app){
	$imgUrl = "";
	$req = $app->request();
	$imgUrl = $req->get('url');

	$response = \Clarifai\Tag::retrieve($imgUrl);

	$oResponse = new stdObject();
	$oResponse->data = array($response);
	echoResponse($oResponse);
});




$app->get("/verify/", function() use($app){
	$imgUrl = "";
	$req = $app->request();
	$imgUrl = $req->get('url');

	$oResponse = new stdObject();
	$response = \Clarifai\NSFW::retrieve($imgUrl);

	$oResponse->status = $response->status_code;

	if($response->status_code == "OK"){
		$tag = $response->results[0]->result->tag;
		if($tag->classes[0] == "sfw"){
			$oResponse->safe = ($tag->probs[0] > 0.5);
		}
		else{
			$oResponse->safe = ($tag->probs[1] > 0.5);
		}
	}
	else {
		$oResponse->data = array($response->status_msg);
	}

	echoResponse($oResponse);
});






$app->get("/product/:id", function($id) use($app){
	$oResponse = new stdObject();
	$product = Product::getProduct($id);
	
	$oResponse->product = $product;
	echoResponse($oResponse);
});

$app->get("/product", function($id) use($app){	
	$product = Product::getProducts();	
	$oResponse = $product;
	echoResponse($oResponse);
});


$app->post("/product", function() use($app){
	$params = $app->request()->post();

	$name = $params['name'];
	$seller = $params['seller'];
	$photo = $params['photo'];

	$response = Product::createProduct($name, $seller, $photo);
		
	$oResponse = new stdObject();
	//$oResponse->data->name = $name;
	echoResponse($oResponse);
});

$app->post("/product/:id/bid", function($id) use($app){
	$params = $app->request->getBody();
	$params = json_decode($params);

	$oResponse = new stdObject();
	echoResponse($oResponse);
});


$app->get("/product/:id/:rate", function($id, $rate) {
	//$params = $app->request->getBody();
	//$params = json_decode($params);


	$oResponse = new stdObject();
	$oResponse->id = $id;
	$oResponse->rate = $rate;
	echoResponse($oResponse);
});






$app->post("/register", function() use($app){
	$params = $app->request->getBody();
	$params = json_decode($params);

	$oResponse = new stdObject();
	echoResponse($oResponse);
});


$app->post("/profile", function() use($app){
	$params = $app->request->getBody();
	$params = json_decode($params);

	$oResponse = new stdObject();
	echoResponse($oResponse);
});
