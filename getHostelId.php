<?php

require_once 'requestInterceptor.php';
include('db_connection.php');
    
// Check connection
if ($conn->connect_error) {
    die(json_encode(array("msg"=>"Connection failed: " . $conn->connect_error)));
}
$user_id = $user['user_id'];
$sql= "SELECT hostel_id from hostel_details where user_id = '$user_id'";
$result = $conn->query($sql);


if ($result->num_rows > 0) {    
    while ($row = $result->fetch_assoc()) {
        $hostel_id = $row["hostel_id"];
        http_response_code(200);
        echo json_encode(array("hostel_id"=>$hostel_id));
        break;
    }
}

else{
    http_response_code(404);
    echo json_encode(array("msg"=> "no hostel found"));
}

?>