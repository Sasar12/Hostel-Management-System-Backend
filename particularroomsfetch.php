<?php
 include('db_connection.php');
 class Room{

    public $room_number;
  
    public $hostelId;
    public $image;
    public $price;
    public $numberOfBeds;
 }
 $room_number = $_GET['room_number'];

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }
    $stm = "SELECT room_number, hostel_id, room_image,price,no_of_beds from room_details where room_number='$room_number' ";
    $result = $conn->query($stm);
    $response = array();
    if ($result->num_rows > 0) {
       while ($row = $result->fetch_assoc()) {
        $room = new Room();
        $room->roomNumber = $row["room_number"];
        $room->hostelId = $row["hostel_id"];
        $room->image = is_null( $row["room_image"] ) ?"": $row["room_image"];
        $room->price = $row['price'];
        $room->numberOfBeds = $row['no_of_beds'];

        array_push($response, $room);
    }
    echo json_encode($response[0]);
  }
    $conn->close();

?>