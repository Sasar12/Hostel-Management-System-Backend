<?php
require 'vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$key ='9842089872';
if(isset($_COOKIE['token'])){
    $decoded = JWT::decode($jwt, new key($key,'HS256'));
}else{
    header('location:login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>welcome<b><?php echo $decoded->data->email ?></b></h1>
</body>
</html>
