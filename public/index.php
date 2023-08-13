<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

// Composer autoloading
include '../vendor/autoload.php';

// Run the application!
// This is so minimalistic, it doesn't even have a front controller.

// Eve Metadata URI - includes the JWKS URI
$metadataUri = 'https://login.eveonline.com/.well-known/oauth-authorization-server';

// Get the JWKS URI from the metadata
$client = new GuzzleHttp\Client();
$response = $client->request('GET', $metadataUri);
$metadata = json_decode($response->getBody(), true);
$jwksUri = $metadata['jwks_uri'];

// Get the JWKS from the JWKS URI
$client = new GuzzleHttp\Client();
$response = $client->request('GET', $jwksUri);
$jwks = json_decode($response->getBody(), true);

// Get the first key from the JWKS (the one used for signing rn. need to improve that later)
$pubkey = $jwks['keys'][0];

$jwk = JOSE_JWK::decode($pubkey); # => phpseclib\Crypt\RSA instance

$jwt_string = $_GET['jwt'];             // get the JWT from the query string
$jwt = JOSE_JWT::decode($jwt_string);   // decode the JWT
$jwt->verify($jwk, 'RS256');            // verify the JWT signature




header('Content-Type: application/json');
echo json_encode($jwt->claims);
