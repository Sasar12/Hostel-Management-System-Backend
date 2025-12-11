<?php
require_once 'requestInterceptor.php';


if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
include('db_connection.php');


$headers = apache_request_headers();

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$hostel_name= $_POST['hostel_name'];
$hostel_address= $_POST['hostel_address'];
$hostel_contact = $_POST['hostel_contact'];
$hostel_pan_num = $_POST['hostel_pan_num'];


// echo $headers['authorization'];
if (!preg_match("/^Bearer\s+(.*)$/", $headers["authorization"], $matches)) {
    http_response_code(400);
    echo json_encode(["message" => "incomplete authorization header"]);
    return false;
}
$token = $matches[1];
$user = $user_gateway->getByAPIKey($token);
$user_id = $user['user_id'];
$average_rating = 0;

$userCheckSql = "select * from hostel_details where hostel_name = '$hostel_name'";
    $user = $conn->query($userCheckSql);
    if ($user->num_rows > 0) {
        http_response_code(400);
        die(json_encode(array("msg"=>_("Hostel with that name already exists"))));
    }
// Prepare SQL statement to insert data into the database
 $stmt = $conn->prepare("INSERT INTO hostel_details (user_id,hostel_name,hostel_address,hostel_contact,hostel_pan_num, average_rating) VALUES (?,?, ?, ?, ?, ?)");
 $stmt->bind_param("issiii",$user_id,$hostel_name,$hostel_address,$hostel_contact,$hostel_pan_num, $average_rating);

 if ($stmt->execute()) {
     echo "New record created successfully";
 } else {
     echo "Error: " . $stmt->error;
 }

 // Close statement and database connection
 $stmt->close();
 $conn->close();
} else {
 echo "Invalid request";
}
?>