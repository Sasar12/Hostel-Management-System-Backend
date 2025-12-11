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
    $booking_id = $conn->real_escape_string($_POST['booking_id']);
    
    // SQL query to delete the room record
    $sql = "DELETE bd.* FROM booking_details bd WHERE bd.booking_id = '$booking_id'";
    
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