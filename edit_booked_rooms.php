<?php
require_once 'requestInterceptor.php';
// Assuming you are receiving POST parameters
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Assuming you have a database connection
    // Replace with your actual database connection details
   include'db_connection.php';

    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $user_id = $user['user_id'];
    // Escape user inputs for security (assuming POST data is used directly)
    $room_number = $conn->real_escape_string($_POST['room_number']);
    $email = $conn->real_escape_string($_POST['email']);
    $booking_id = $conn->real_escape_string($_POST['booking_id']);

    $roomSql = "SELECT rd.* FROM room_details rd inner join hostel_details hd on hd.hostel_id = rd.hostel_id where hd.user_id = '$user_id' and rd.room_number = '$room_number'";
    $result = $conn->query($roomSql);
    if ($result->num_rows > 0) {

        // SQL query to update the room record
        $sql = "UPDATE booking_details bd SET bd.room_number = $room_number , bd.user_id = (SELECT user_id from user_details where email = '$email') WHERE booking_id = '$booking_id'";
        
        if ($conn->query($sql)) {
            echo "Room updated successfully";
        } else {
            http_response_code(500);
            echo json_encode(array("msg"=>"Error updating room: " . $conn->error));
        }

    } else {
        http_response_code(400);
        echo json_encode(array("msg"=>"No hostel found with that room number"));
    }

    
    
    $conn->close();
} else {
    echo "Method not allowed";
}
?>