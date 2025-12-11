<?php
require_once 'requestInterceptor.php';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
include('db_connection.php');

    if ($conn->connect_error) {
        http_response_code(500) ;
        die("Connection failed: " . $conn->connect_error);
        }
        else{
            $reviews = $_POST['reviews'];
            $rating = $_POST['rating'];
            $user_id = $user['user_id'];
            $hostel_id = $_POST['hostel_id'];
            // Prepare SQL statement to insert data into the database
            $sql= "INSERT INTO Review_table(hostel_id,user_id,reviews,rating)  VALUES ('$hostel_id', '$user_id', '$reviews', '$rating')";
    
            if($conn->query($sql)){
                echo json_encode(array("msg"=>"review inserted successfully"));
            }else{
                echo json_encode(array("msg"=>"Error inserting room".$sql. " : " .$conn->error));
            }
        }
        
    }
else {
    http_response_code(405);
    // Invalid request method, return error
    echo json_encode(array("msg"=>"invalid method"));
}
   
?>