<?php
require_once'vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$config = require_once'config.php';

$secret_key = $config['jwt-secret'];

$headers = apache_request_headers();
if (isset($headers['Authorization'])){
    $authorizationHeader = $headers['Authorization'];
    // print_r($authorizationHeader);
    $headerValue = explode(' ', $authorizationHeader);
    $jwt = $headerValue[1];
    try{
    $decoded = JWT::decode($jwt, new key($secret_key,'HS256'));
    print_r($decoded);
    
    }catch(Exception $e){
        echo"Error: ". $e->getMessage();
}
}else{
    echo " No authorization header is present";
}

 $data =[
    "name"=> "This is my product",
    "code"=> "694",
 ];
// print_r($data);
?>