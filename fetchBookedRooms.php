<?php
 include('db_connection.php');
 include 'requestInterceptor.php';
 class Room{
  public $email;

  public $hostelName;
  public $bookingId;
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
    $stm = "SELECT bd.booking_id, ud.email, hd.hostel_name, hd.hostel_id, bd.room_number, rd.room_number, rd.price, rd.no_of_beds, rd.no_of_avail_beds, rd.room_image from booking_details bd inner join user_details ud on bd.user_id = ud.user_id inner join hostel_details hd on bd.hostel_id = hd.hostel_id  inner join room_details rd on bd.room_number = rd.room_number where hd.user_id = '$user_id'";
    $result = $conn->query($stm);
    $response = array();
    if ($result->num_rows > 0) {
       while ($row = $result->fetch_assoc()) {
        $room = new Room();
        // $room->image = is_null($row['room_image'])?" ":$row['room_image'];
        $room->email = $row["email"];
        $room->hostelName = $row["hostel_name"];
        $room->bookingId = $row["booking_id"];
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