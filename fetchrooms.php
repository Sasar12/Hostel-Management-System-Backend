<?php
 include('db_connection.php');
//  $image = $_POST['room_image'];
//  $roomNumber = $_POST['room_number'];
//  $price = $_POST['price'];
//  $numberOfBeds = $_POST['no_of_beds'];
 // Check connection

 include 'requestInterceptor.php';
 class Room{
    public $hostelId;

    public $image;
    public $roomNumber;
    public $price;
    public $numberOfBeds;
 }

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }
    
    $user_id = $user['user_id'];
    $stm = "SELECT rd.hostel_id, rd.room_image, rd.room_number, rd.price, rd.no_of_beds from room_details  rd inner join hostel_details hd on rd.hostel_id = hd.hostel_id where hd.user_id = '$user_id'";
    $result = $conn->query($stm);
    $response = array();
    if ($result->num_rows > 0) {
       while ($row = $result->fetch_assoc()) {
        $room = new Room();
        // $room->image = is_null($row['room_image'])?" ":$row['room_image'];

        $room->image = is_null( $row["room_image"] ) ?"": $row["room_image"];
        $room->hostelId = $row["hostel_id"];
        $room->roomNumber = $row['room_number'];
        $room->price = $row['price'];
        $room->numberOfBeds = $row['no_of_beds'];

        array_push($response, $room);
    }
    echo json_encode($response);
  }
    $conn->close();

?>