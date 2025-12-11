
// include('db_connection.php');

// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
//     }
//     $sql = "DELETE From room_details where room_number = ?";
//     if($conn->query($sql)==true){
//         echo"data deleted successfully";
//     }else{
//         echo "error deleting record" . $conn->error;
//     }
//     $conn->close();
<?php

require_once 'requestInterceptor.php';
// Assuming you are receiving POST parameters
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    include'db_connection.php';
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $user_id = $user['user_id'];
    // Escape user input for security (assuming POST data is used directly)
    $room_number = $conn->real_escape_string($_POST['room_number']);
    
    // SQL query to delete the room record
    $sql = "DELETE rd.* FROM room_details rd inner join hostel_details hd on rd.hostel_id = hd.hostel_id WHERE rd.room_number = '$room_number' and hd.user_id = '$user_id'";
    
    if ($conn->query($sql) === TRUE) {
        echo "Room deleted successfully";
    } else {
        echo "Error deleting room: " . $conn->error;
    }
    
    $conn->close();
} else {
    echo "Method not allowed";
}
?>
