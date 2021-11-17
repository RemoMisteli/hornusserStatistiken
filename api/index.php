<?php

include_once("rest.php");
include_once("dbUtils.php");
include_once("controller.php");
session_start();

// Connect to the database
try {
	dbUtils::connectDB();
} catch (Exception $e) {
	rest::setHttpHeaders(422, true);
}

// Get requested method
$method = $_SERVER['REQUEST_METHOD'];


// Read post, put, delete data from client
$dataFromClient = json_decode(file_get_contents('php://input'));



// Read get data from client
foreach ( $_GET as $pname => $pvalue ) {
	if ( !$dataFromClient )  $dataFromClient = new stdClass();
	$dataFromClient->$pname = $pvalue;
}

// Run controller
$dataToClient = controll::controller($dataFromClient->ressource, $method,$dataFromClient);

// Send response to client
rest::sendStatusAndData($dataToClient['status'], $dataToClient['data']);

?>