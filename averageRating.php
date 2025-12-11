<?php

require_once 'requestInterceptor.php';


if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
include('db_connection.php');

$hostel_id = $_POST['hostel_id'];
// Prepare SQL statement to insert data into the database
$average_rating = $_POST['average_rating'];
$sql = "UPDATE hostel_details SET average_rating = '$average_rating' where hostel_id = '$hostel_id'";
if($conn->query($sql)){
    echo json_encode(array("msg"=>"average rating inserted successfully"));
}else{
    echo json_encode(array("msg"=>"Error inserting average rating".$sql. " : " .$conn->error));
}

// Close statement and database connection

$conn->close();
}
?>
