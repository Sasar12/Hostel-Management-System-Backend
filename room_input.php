<?php
include('db_connection.php');
require_once 'requestInterceptor.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$currentDateTime = date("Y-m-d_H:i:s");


// Retrieve data sent from Flutter app
$photoUpload = isset($_FILES['room_image']) ? $_FILES['room_image'] : null;
$roomNumber = $_POST['room_number'];
$price = $_POST['price'];
$numberOfBeds = $_POST['no_of_beds'];


$uploadDirectory = 'uploads/';
     if (!is_dir($uploadDirectory)) {
         mkdir($uploadDirectory, 0777, true);
     }

     $photoUploadPath = '';
     if ($photoUpload && !empty($photoUpload['name'])) {
     $ext = pathinfo($photoUpload['name'], PATHINFO_EXTENSION);

    // Generate unique name using timestamp
    $uniqueName = uniqid() . '.' . $ext;

    
     echo $photoUpload['tmp_name'];   
     echo $photoUploadPath;
     if (!move_uploaded_file($photoUpload['tmp_name'], $uploadDirectory . $uniqueName)) {
         echo "Error moving photo upload file";
        exit();
     }
    }

$user_id = $user['user_id'];
$hostel_sql = "SELECT hd.hostel_id from hostel_details hd where hd.user_id = '$user_id'";
$hostel_result = $conn->query($hostel_sql);
if ($hostel_result->num_rows > 0) {
    
    while($row = $hostel_result->fetch_assoc()){
        $hostel_id = $row["hostel_id"];
    }
}


// Prepare SQL statement to insert data into the database
$stmt = $conn->prepare("INSERT INTO room_details (hostel_id, room_image, room_number, price, no_of_beds,no_of_avail_beds) VALUES (?,?, ?, ?, ?, ?)");
$stmt->bind_param("issssi",$hostel_id, $uniqueName, $roomNumber, $price, $numberOfBeds,$numberOfBeds);
 if ($stmt->execute()) {
    echo "New record created successfully";
} else {
    echo "Error: " . $stmt->error;
}

// Close statement and database connection
$stmt->close();
$conn->close();

?>
