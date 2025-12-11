<?php
include('db_connection.php');
require_once 'requestInterceptor.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }
  $sql = "SELECT hd.hostel_id, hd.hostel_name, ud.email ,hd.hostel_address,hd.hostel_contact,hd.hostel_pan_num from hostel_details  hd inner join user_details ud on hd.user_id = ud.user_id where user_type = 'owner'";
  $result = $conn->query($sql);
  $finalResponse = array();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      
        $data = array("id"=>$row['hostel_id'],"hostel_name"=> $row['hostel_name'], "email"=> $row['email'],"hostel_address"=> $row['hostel_address'], "hostel_contact"=> $row['hostel_contact'],"hostel_pan_num"=> $row['hostel_pan_num']);
        header('Content-Type: application/json; charset=utf-8');
        array_push($finalResponse, $data);        
    }
    } 

echo json_encode(array("data"=>$finalResponse));

?>