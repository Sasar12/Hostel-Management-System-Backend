
<!-- include('db_connnection.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }
    $roomNumber = $_POST["room_number"];
    $sql = "SELECT room_image,room_number,price,no_of_beds FROM room_details where room_number = $roomNumber";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        // You can use $row values to pre-fill the form fields for editing
        $photoUpload = $row['room_image'];
        $roomNumber = $row['room_number'];
        $price = $row['price'];
        $numberOfBeds = $row['no_of_beds'];
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Handle form submission for updating hostel information
        $new_photoUpload = isset($_FILES['room_image']) ? $_FILES['room_image'] : null;
        $new_roomNumber = $_POST['room_number'];
        $new_price = $_POST['price'];
        $new_numberOfBeds = $_POST['no_of_beds'];

        $uploadDirectory = 'uploads/';
        if (!is_dir($uploadDirectory)) {
            mkdir($uploadDirectory, 0777, true);
        }
        //Move uploaded photo file
       $photoUploadPath = '';
       if ($new_photoUpload && !empty($new_photoUpload['name'])) {
       $photoUploadPath = $uploadDirectory . $new_roomNumber. '.jpg';    
       if (!move_uploaded_file($photoUpload['tmp_name'], $photoUploadPath)) {
           echo "Error moving photo upload file";
          exit();
       }
   }
    
        $update_sql = "UPDATE Hostels 
                       SET
                            room_image= '$photoUploadPath', 
                           room_number = '$new_roomNumber', 
                           price = '$new_price', 
                           no_of_beds = '$new_numberOfBeds', 
                       where room_number = $roomNumber";
                if (mysqli_query($conn, $update_sql)) {
                    // Hostel information updated successfully
                    echo "success";
                } else {
                    echo "Error updating hostel information: " . mysqli_error($conn);
                }

            } 
            mysqli_close($conn);
 -->
 
 <?php
// Assuming you are receiving POST parameters
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Assuming you have a database connection
    // Replace with your actual database connection details
   include'db_connection.php';

    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Escape user inputs for security (assuming POST data is used directly)
    $photoUpload = isset($_FILES['room_image']) ? $_FILES['room_image'] : null;
    $room_number = $conn->real_escape_string($_POST['room_number']);
    $price = $conn->real_escape_string($_POST['price']);
    $no_of_beds = $conn->real_escape_string($_POST['no_of_beds']);

    $uploadDirectory = 'uploads/';
     if (!is_dir($uploadDirectory)) {
         mkdir($uploadDirectory, 0777, true);
     }

     $photoUploadPath = '';
     if ($photoUpload && !empty($photoUpload['name'])) {
     $photoUploadPath = $currentDateTime . '.jpg'; 
     echo $photoUpload['tmp_name'];   
     echo $photoUploadPath;
     if (!move_uploaded_file($photoUpload['tmp_name'], $uploadDirectory . $photoUploadPath)) {
         echo "Error moving photo upload file";
        exit();
     }
    }
    
    // SQL query to update the room record
    $sql = "UPDATE room_details SET room_image = '$photoUploadPath', price = '$price', no_of_beds = '$no_of_beds' WHERE room_number = '$room_number'";
    
    if ($conn->query($sql) === TRUE) {
        echo "Room updated successfully";
    } else {
        echo "Error updating room: " . $conn->error;
    }
    
    $conn->close();
} else {
    echo "Method not allowed";
}
?>
