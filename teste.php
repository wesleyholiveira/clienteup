<?php

require_once 'vendor/autoload.php';

phpinfo();

// use Lcobucci\JWT\Builder;
// use Lcobucci\JWT\Signer\Hmac\Sha256;

// $signer = new Sha256();

// $token = (new Builder())->setIssuer('http://example.com') // Configures the issuer (iss claim)
//                         ->setAudience('http://example.org') // Configures the audience (aud claim)
//                         ->setIssuedAt(time()) // Configures the time that the token was issue (iat claim)
//                         ->setNotBefore(time() + 60) // Configures the time that the token can be used (nbf claim)
//                         ->setExpiration(time() + 3600) // Configures the expiration time of the token (nbf claim)
//                         ->set('uid', 1) // Configures a new claim, called "uid"
//                         ->set('username', 'wesley h  oliveira')
//                         ->sign($signer, 'testing') // creates a signature using "testing" as key
//                         ->getToken(); // Retrieves the generated token


// var_dump($token->verify($signer, 'testing 1')); // false, because the key is different
// var_dump($token->verify($signer, 'testing')); // true, because the key is the same
// var_dump($token->getClaim('username'));