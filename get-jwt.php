<?php
require_once'vendor/autoload.php';

use Firebase\JWT\JWT;
$config = require_once'config.php';

$secret_key = $config['jwt-secret'];

$payload = array(
    'iss' => 'helan',
    'iat' => time(),
    'exp' => time(),
    'email' => '',
);
$jwt = JWT::encode($payload, $secret_key,'HS256') ;
echo "JWT :".$jwt;


?>