<?php


$app->get("/", function() use($app){
	echo "We are Buyoner!";
});

$app->get("/search/:tag", function($tag) use($app){
	$query = new \Parse\ParseQuery("Product");
	try {
		$result = $query->containsAll("tags", array($tag));
	} catch(\Parse\ParseException $ex){
	}
});

$app->get("/search/", function() use($app){
	$imgUrl = "";
	$req = $app->request();
	$imgUrl = $req->get('url');
	
	$oResponse = new stdObject();
	$response = \Clarifai\Tag::retrieve($imgUrl);

	$oResponse->status = $response->status_code;
	if($response->status_code == "OK"){
		$oResponse->tags = $response->results[0]->result->tag->classes;
	}
	else {
		$oResponse->data = array($response->status_msg);
	}
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



$app->get("/product", function() use($app) {
	$product = Product::getProducts();
	$oResponse = $product;
	echoResponse($oResponse);
});


$app->get("/product/:id", function($id) use($app){
	$oResponse = new stdObject();
	$product = Product::getProduct($id);

	$oResponse->product = $product;
	echoResponse($oResponse);
});


$app->post("/product", function() use($app){
	$params = $app->request->post();
	$oResponse = new stdObject();
	$name = $params['name'];
	$seller = $params['seller'];
	$photo = $params['photo'];
	$price = $params['price'];
	$docid =  "";

	$verify_photo = \Clarifai\NSFW::retrieve($photo);
	$safe = false;
	if($verify_photo->status_code == "OK"){
		$docid = $verify_photo->results[0]->docid;
		$tag = $verify_photo->results[0]->result->tag;
		if($tag->classes[0] == "sfw")
			$safe = ($tag->probs[0] > 0.5);
	}
	if($safe){
		$product_tags = \Clarifai\Tag::retrieve($photo);
		if($product_tags->status_code == "OK"){
			$product_tags = $product_tags->results[0]->result->tag->classes;
		}

		$product_insertion = Product::createProduct($name, $seller, $photo, $price, $docid);
		$oResponse->status = "Product inserted";

		$object = \Parse\ParseObject::create("Product");
		$objectId = $object->getObjectId();

		$object->set("docid", $docid);
		$object->setArray("tags", $product_tags);
		$object->save();
	}
	else {
		$oResponse->status = "Upload has content prohibited";
	}
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
