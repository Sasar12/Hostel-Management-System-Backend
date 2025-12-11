<?php
include('db_connection.php');
require_once 'requestInterceptor.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }
  $sql = "SELECT rd.review_id, rd.reviews , hd.hostel_name, ud.email from Review_table rd inner join hostel_details hd on rd.hostel_id = hd.hostel_id  inner join user_details ud on rd.user_id = ud.user_id where ud.user_type = 'student'";
  $result = $conn->query($sql);
  $finalResponse = array();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      
        $data = array("id"=>$row['review_id'], "reviews"=>$row['reviews'],"hostel_name"=> $row['hostel_name'], "email"=> $row['email']);
        header('Content-Type: application/json; charset=utf-8');
        array_push($finalResponse, $data);        
    }
    } 
    

echo json_encode(array("data"=>$finalResponse));

?>