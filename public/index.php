<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
//chdir(dirname(__DIR__));

// Composer autoloading
include '../vendor/autoload.php';

require_once '../config/config.php';


// Run the application!
// This is so minimalistic, it doesn't even have a front controller.

$config = new Config();


// Eve Metadata URI - includes the JWKS URI
$metadataUri = 'https://login.eveonline.com/.well-known/oauth-authorization-server';

// Get the JWKS URI from the metadata
$client = new GuzzleHttp\Client();
$response = $client->request('GET', $metadataUri);
$metadata = json_decode($response->getBody(), true);
$jwksUri = $metadata['jwks_uri'];

// Get the JWKS from the JWKS URI
use GuzzleHttp\Client;
$client = new GuzzleHttp\Client();
$response = $client->request('GET', $jwksUri);
$jwks = json_decode($response->getBody(), true);


//header('Content-Type: application/json');
//echo json_encode($jwks);

$pubkey = $jwks['keys'][0];
//$pubkey['n'] = str_replace('_', '/', $pubkey['n']);
//$pubkey['n'] = str_replace('-', '+', $pubkey['n']);
//$pubkey['n'] = "-----BEGIN PUBLIC KEY-----" . $pubkey['n'] . "-----END PUBLIC KEY-----";
//$pubkey = $jwks['keys'][0]['n'];
//$pubkey = str_replace('_', '/', $pubkey);
//$pubkey = str_replace('-', '+', $pubkey);
//$pubkey = "-----BEGIN PUBLIC KEY-----" . $pubkey . "-----END PUBLIC KEY-----";
//$pubkey = base64_encode($pubkey);

$jwk = JOSE_JWK::decode($pubkey); # => phpseclib\Crypt\RSA instance

$jwt_string = $_GET['jwt'];
$jwt = JOSE_JWT::decode($jwt_string);
//$jwt->verify($pubkey, 'RS256');
$jwt->verify($jwk, 'RS256');
//print_r($jwt);
header('Content-Type: application/json');
echo json_encode($jwt->claims);
//$jws = new JOSE_JWS($jwt);
//echo $jws->toJSON();
//echo json_encode((array)$jwt);
