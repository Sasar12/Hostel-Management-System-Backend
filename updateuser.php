<?php
include('db_connection.php');
 // Check connection
 if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
    $first_name =$_POST['first_name'];
    $last_name =$_POST['last_name'];
    $user_type =$_POST['user_type'];
    $phone_number =$_POST['phone_number'];
    $password =$_POST['password'];
    $email=$_POST['email'];
    $address =$_POST['address'];
    $user_id = $_POST['id'];

     // SQL query to update the room record
     $sql1 = "UPDATE user_details SET first_name = '$first_name', last_name = '$last_name', user_type = '$user_type',phone_number = '$phone_number', password = '$password', email = '$email',address = '$address' WHERE user_id = '$user_id'";
    
     if ($conn->query($sql1) === TRUE) {
        http_response_code(200);
         echo "Users updated successfully";
     } else {
        http_response_code(500);
         echo "Error updating hostel: " . $conn->error;
     }
     
     $conn->close();
?>