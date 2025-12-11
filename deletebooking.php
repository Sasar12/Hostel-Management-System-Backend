<?php
     include('db_connection.php');
    
     // Check connection
     if ($conn->connect_error) {
         die("Connection failed: " . $conn->connect_error);
     }
     $bookingId = $_POST['booking_id'];
    $room_number = $_POST['room_number'];
    $hostel_id = $_POST['hostel_id'];     
    $updateSql = "UPDATE room_details rd SET rd.no_of_avail_beds = (rd.no_of_avail_beds + 1) where rd.hostel_id = '$hostel_id' and rd.room_number = '$room_number'";

     if($conn->query($updateSql)) {
        echo json_encode(array("msg"=>"Incremented"));
     } else {
        http_response_code(500);
        echo json_encode(array("msg"=> "". mysqli_error($conn)));
     }
     $sql = " DELETE bd.* From booking_details bd where bd.booking_id = '$bookingId' ";
     
     if($conn->query($sql)) {
        echo json_encode(array("msg"=>"Successfull"));
     } else {
        http_response_code(500);
        echo json_encode(array("msg"=> "". mysqli_error($conn)));
     }

?>