<?php

function getConnection(){
	$connection= null;
	try {
		$connection= new PDO("mysql:host=".Config::getDBServer().";dbname=".Config::getDBName().";charset=utf8", Config::getDBUsername(), Config::getDBPassword());
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $connection;
	} catch (PDOException $e) {
		echo "Error: Database connection issues.";
	}
}

function echoResponse($response){
	$app = \Slim\Slim::getInstance();
	$app->contentType('application/json');
	echo json_encode($response);
}

function echoResponseRaw($response){
	$app = \Slim\Slim::getInstance();
	$app->contentType('application/json');
	echo $response;
}


function getData($query, $type){
	try {
		$datos= [];

		$con = getConnection();
		$data = $con->prepare($query);
		$data->execute();

		switch ($type) {
			case 'all':
				$datos= $data->fetchAll();
				break;
			
			case 'one':
				$datos= $data->fetchObject();
				break;

			default:
				$datos= [];
				break;
		}

		$con= null;
		return $datos;
	} catch (PDOException $e) {
		return "Error: Data not available.";
	}
}


function postData($query, $type){
	try {
		$datos= [];
		
		$con= getConnection();
		$data= $con->prepare($query);
		$data->execute();

		switch ($type) {
			case 'insert':
				$datos= $con->lastInsertId();
				break;

			case 'update':
				$datos= $data->rowCount();
				break;

			case 'delete':
				$datos= $data->rowCount();
				break;
		}
		$con= null;
		return $datos;
	} catch (PDOException $e) {
		return "Error: Data not available.";
	}
}




?>