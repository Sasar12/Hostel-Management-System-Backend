<?php
// Check if the POST request contains the required data
if ($_SERVER["REQUEST_METHOD"] == "POST" ) {

    // Establish a connection to the MySQL database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Final_project";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
     // Set parameters and execute the statement
     $first_name = $_POST['first_name'];
     $last_name = $_POST['last_name'];
     $user_type = $_POST['user_type'];
     $phone_number = $_POST['phone_number'];
     $email = $_POST['email'];
     $password = $_POST['password'];
     $hostel_name = $_POST['hostel_name'];
     $address = $_POST['address'];
     $photoUpload = isset($_FILES['photo_upload']) ? $_FILES['photo_upload'] : null;

     $uploadDirectory = 'uploads/';
     if (!is_dir($uploadDirectory)) {
         mkdir($uploadDirectory, 0777, true);
     }
     //Move uploaded photo file
    $photoUploadPath = '';
    if ($photoUpload && !empty($photoUpload['name'])) {
    $photoUploadPath = $uploadDirectory . $first_name . $last_name . '.jpg';    
    if (!move_uploaded_file($photoUpload['tmp_name'], $photoUploadPath)) {
        echo "Error moving photo upload file";
       exit();
    }
}
    $userCheckSql = "select * from user_details where email = '$email'";
    $user = $conn->query($userCheckSql);
    if ($user->num_rows > 0) {
        http_response_code(400);
        die(json_encode(array("msg"=>_("User with email already exists"))));
    } 

    // Prepare SQL statement to insert data into the database
    $stmt = $conn->prepare("INSERT INTO user_details (first_name, last_name, user_type, phone_number, email, `password`, hostel_name, `address`,photo_upload) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssisssss", $first_name, $last_name, $user_type, $phone_number, $email, $password, $hostel_name, $address,$photoUploadPath);

    if ($stmt->execute()) {
        http_response_code(200);
        echo json_encode(array("msg"=>"New record created successfully"));
    } else {
        http_response_code(500);
        echo json_encode(array("msg"=>"Error: " . $stmt->error));
    }

    // Close statement and database connection
    $stmt->close();
    $conn->close();
} else {
    http_response_code(400);
    echo json_encode(array("msg"=>"Invalid request"));
}
?>