<?php
include('db_connection.php');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }
  $sql = "SELECT user_id,first_name,last_name,email,phone_number,`password`,hostel_name,`address`,photo_upload,user_type from user_details where user_type != 'admin'";
  $result = $conn->query($sql);
  $finalResponse = array();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $res1 = $row["first_name"];
        $res2 = $row["last_name"];
        $res3 = $row["email"];
        $res4 = $row["phone_number"];
        $res5 = $row["password"];
        $res6 = $row["hostel_name"];
        $res7 = $row["address"];
        $res8 = $row["photo_upload"];
        $res9 = $row["user_type"];
        $data = array("id"=>$row['user_id'],"first_name"=> $res1,"last_name"=> $res2,"email"=> $res3,"phone_number"=> $res4,"password"=> $res5,"hostel_name"=> $res6,"address"=> $res7,"photo_upload"=> $res8,"user_type"=> $res9);
        header('Content-Type: application/json; charset=utf-8');
        array_push($finalResponse, $data);        
    }
    } 
    else {    
        http_response_code(404);
        echo json_encode(array('msg'=>"no users found"));
    }

echo json_encode(array("data"=>$finalResponse));

?>