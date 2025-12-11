<?php
// Check if the request method is GET
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
include('db_connection.php');
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(array('msg'=>"Connection failed: " . $conn->connect_error));
    }
    $hostel_id = $_GET['hostel_id'];
    $sql1 = "SELECT u.email,r.reviews,r.rating From user_details u join Review_table r on u.user_id = r.user_id where r.hostel_id = '$hostel_id'";
    $result = $conn->query($sql1);
    $finalResponse = array();
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()) {
            $res = $row['email'];
            $res2 = $row['reviews'];
            $res3 = $row['rating'];
            $data = array("email"=> $res,"reviews"=> $res2,"rating"=> $res3);
            header('Content-Type: application/json; charset=utf-8');
            
            array_push($finalResponse, $data);
        }
        http_response_code(200);
    echo json_encode($finalResponse);
    }else{
        http_response_code(404);
        echo json_encode(array('msg'=>"no reviews found"));
    }
    
}else {
    // Invalid request method, return error
    echo "invalid method";
}

?>