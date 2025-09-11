<?php

//config.php
$inicio_sesion = "";
$host= $_SERVER["HTTP_HOST"];
$url= $_SERVER["REQUEST_URI"];
if($host == "localhost:3330"){
    $inicio_sesion = 'http://localhost:3330/novomode/source/login';
}
else{
    $inicio_sesion = 'http://novomode.loginto.me:81/novomode/source/login';
}

//Include Google Client Library for PHP autoload file
//require_once 'vendor/autoload.php';
require_once 'vendors/apiclient/vendor/autoload.php';

//Make object of Google API Client for call Google API
$google_client = new Google_Client();

//Set the OAuth 2.0 Client ID
$google_client->setClientId('326569528321-a0ukq6oojdmj4nkds6gkgvkvhknk3hgt.apps.googleusercontent.com');

//Set the OAuth 2.0 Client Secret key
$google_client->setClientSecret('4DIWNq8g47sgvj4xitU11-gM');

//Set the OAuth 2.0 Redirect URI
$google_client->setRedirectUri($inicio_sesion);
//$google_client->setRedirectUri();

//
$google_client->addScope('email');

$google_client->addScope('profile');

//start session on web page
session_start();

?>