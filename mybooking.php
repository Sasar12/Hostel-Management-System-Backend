<?php
require_once 'requestInterceptor.php';
include('db_connection.php');
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$user_id = $user['user_id'];
$sql = "SELECT bd.booking_id, hd.hostel_id, hd.hostel_name,hd.hostel_address,hd.hostel_contact,rd.room_image,rd.room_number  from booking_details bd inner join hostel_details hd on hd.hostel_id = bd.hostel_id inner join room_details rd on rd.room_number = bd.room_number where bd.user_id = '$user_id' ";
$result = $conn->query($sql);
$res = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()){
        array_push($res, array("booking_id"=>$row['booking_id'],"hostel_id"=>$row['hostel_id'],"hostel_name"=>$row['hostel_name'],"hostel_address"=>$row['hostel_address'],"hostel_contact"=>$row['hostel_contact'],"room_image"=>$row['room_image'],"room_number"=>$row['room_number'] ));
    }

}
echo json_encode($res);

?> 