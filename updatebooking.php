<?php
include('db_connection.php');
 // Check connection
 if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
    $bookingId = $_POST['id'];
    $hostel_name =$_POST['hostel_name'];
    $email = $_POST['email'];
    $room_number = $_POST['room_number'];

    $checkSql = "SELECT * from room_details rd inner join hostel_details hd on rd.hostel_id = hd.hostel_id where hd.hostel_name = '$hostel_name' and rd.room_number = '$room_number'";
    $result = $conn->query($checkSql);
    if ($result->num_rows > 0) {    

     // SQL query to update the room record
     $sql1 = "UPDATE booking_details bd inner join user_details ud on bd.user_id = ud.user_id set bd.hostel_id = (select hd.hostel_id from hostel_details hd where hd.hostel_name = '$hostel_name'), bd.room_number = '$room_number' where ud.email = '$email' and bd.booking_id = '$bookingId'";
    
     if ($conn->query($sql1) === TRUE) {
        http_response_code(200);
         echo json_encode(array("msg"=>"Booking updated successfully"));
     } else {
        http_response_code(500);
         echo json_encode(array("msg"=>"Error updating room: " . $conn->error));
     }
    }
    else {  
        http_response_code(400) ;
        echo json_encode(array("msg"=> "No hostel or room with that value found"));
    }
     $conn->close();
?>