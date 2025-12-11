<?php
include('db_connection.php');
 // Check connection
 if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
    $hostel_name =$_POST['hostel_name'];
    $hostel_address =$_POST['hostel_address'];
    $hostel_contact =$_POST['hostel_contact'];
    $hostel_pan_num =$_POST['hostel_pan_num'];
    $hostel_id = $_POST['id'];
    
     // SQL query to update the room record
     $sql1 = "UPDATE hostel_details hd SET hd.hostel_name = '$hostel_name', hd.hostel_address = '$hostel_address', hd.hostel_contact = '$hostel_contact', hd.hostel_pan_num = '$hostel_pan_num' where hd.hostel_id = '$hostel_id'";
    
     if ($conn->query($sql1)) {
        http_response_code(200);
         echo "hostels updated successfully";
     } else {
        http_response_code(500);
         echo "Error updating hostels: " . $conn->error;
     }
     
     $conn->close();
?>