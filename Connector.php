<?php

include('db_connection.php');
require_once 'requestInterceptor.php';

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$user_id = $user['user_id'];
// echo($user_id);
$sql = "SELECT user_id From hostel_details where user_id ='$user_id' ";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  http_response_code(200);    
}else{
    http_response_code(404);
}
?>