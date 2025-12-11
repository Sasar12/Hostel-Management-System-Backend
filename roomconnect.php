<?php

// include('db_connection.php');

//   // Check connection
//   if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }
// $hostel_name = $_POST['hostel_name'];
// $sql = "SELECT r.room_number From hostel_details h join room_details r on h.hostel_id = r.hostel_id where h.hostel_name='$hostel_name' ";
// $result = $conn->query($sql);
// if ($result->num_rows > 0) {
//     $rows = array();
//     while ($row = $result->fetch_assoc()) {
//         $rows[''] = $row['room_number'];
//         echo($rows);
//     }
    
// }else{
//     http_response_code(404);
//     echo "error";
// }
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Final_project";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $hostel_name = $_POST['hostel_name']; // Replace with your column name
    

    
    $stmt = "SELECT r.room_number, r.hostel_id, r.room_image, r.price, r.no_of_beds, r.no_of_avail_beds From hostel_details h join room_details r on h.hostel_id = r.hostel_id where h.hostel_name='$hostel_name' and r.no_of_avail_beds > 0";
    $result = $conn->query($stmt);
    
    $resp = array();
    if ($result->rowCount() > 0) {
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
         
 
         array_push($resp, array(
            "no_of_avail_beds"=>($row["no_of_avail_beds"]),
            "room_number"=>($row["room_number"]),
            "hostel_id"=>$row["hostel_id"],
            "room_image"=>$row["room_image"],
            "room_price"=>$row["price"],
            "no_of_beds"=>($row["no_of_beds"]),
        ));

     }
    }
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($resp);
    
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$conn = null; // Close connection
?>
