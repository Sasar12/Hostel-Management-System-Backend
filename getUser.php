<?php

    require_once 'UserGateway.php';
    require_once 'Database.php';
    require_once 'requestInterceptor.php';

    $headers = apache_request_headers();


    $servername = "localhost"; // Change this to your database server name
    $username = "root"; // Change this to your database username
    $password_db = ""; // Change this to your database password
    $dbname = "final_project"; // Change this to your database name
    
    
    
    $database = new Database($servername, $dbname, $username, $password_db);

    $user_gateway = new UserGateway($database);

    if (!preg_match("/^Bearer\s+(.*)$/", $headers["authorization"], $matches)) {
        http_response_code(400);
        echo json_encode(["message" => "incomplete authorization header"]);
        return false;
    }
    $token = $matches[1];
    $user = $user_gateway->getByAPIKey($token);

    echo json_encode(["user_id"=>$user['user_id']]);

