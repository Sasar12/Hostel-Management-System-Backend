<?php

require_once 'requestInterceptor.php';
include('db_connection.php');
    
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// $user_id = $user['user_id'];
$sql = "SELECT DISTINCT ud.hostel_name, ud.average_rating, ud.hostel_id,(
        SELECT GROUP_CONCAT(DISTINCT rd.room_image)
        FROM room_details rd
        WHERE rd.hostel_id = ud.hostel_id
        AND rd.room_image <> ''
    ) AS room_images, (SELECT COUNT(rt.hostel_id) FROM `Review_table` rt WHERE rt.hostel_id = ud.hostel_id  ) as total_reviews FROM hostel_details ud order by ud.hostel_id desc";
$result = $conn->query($sql);

$hostelList = array();
if ($result->num_rows > 0) {    
    while ($row = $result->fetch_assoc()) {
        array_push($hostelList, array("hostel_id"=>$row['hostel_id'], "hostel_name"=>$row['hostel_name'], "average_rating"=>$row['average_rating'], "room_images"=>array_filter(explode(",", $row['room_images']), function($img){ return !empty($img);}), "total_reviews"=>$row['total_reviews']));
    }

   
}
http_response_code(200);
echo json_encode($hostelList);

?>