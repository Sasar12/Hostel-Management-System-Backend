<?php

    require_once 'requestInterceptor.php';

    
if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
    include('db_connection.php');
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $roomNumber= $_POST['roomNumber'];
    $hostelid = $_POST['hostelId'];
    $user_id = $user['user_id'];


        $sql1 = "SELECT no_of_avail_beds FROM room_details WHERE hostel_id = '$hostelid' and room_number = '$roomNumber'";
        $result = $conn->query($sql1);
        
        
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $numberOfBeds = $row['no_of_avail_beds'];
            }
            
            // Update available rooms count
            if($numberOfBeds<=0){
                http_response_code(404);
                echo json_encode(array("msg"=>"no available rooms"));
            }else{
            $updatedRooms = $numberOfBeds - 1; // Decrease available rooms by 1
            $updateHostelQuery = "UPDATE room_details SET no_of_avail_beds = (no_of_avail_beds - 1) WHERE hostel_id = '$hostelid' and room_number = '$roomNumber'";
            $result = $conn->query($updateHostelQuery);
           
                // Prepare SQL statement to insert data into the database
            $stmt = $conn->prepare("INSERT INTO booking_details (user_id,hostel_id, room_number) VALUES (?, ?, ?)");
            $stmt->bind_param("iii",$user_id,$hostelid,$roomNumber);
            $stmt->execute();
            http_response_code(200);
            }
    
            $stmt->close();
            $conn->close();
            
            exit();
        } else {
            http_response_code(404);
            echo json_encode(array("msg"=>"Hostel not found"));
        }
    
    } else {
        http_response_code(500);
        echo json_encode(array("msg"=>"Connection error"));
    }

?>