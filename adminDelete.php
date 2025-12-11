<?php

require_once 'requestInterceptor.php';
// Assuming you are receiving POST parameters
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    
    include'db_connection.php';
    
    if($user['user_type'!='admin']){
        http_response_code(403);
        echo json_encode(array('msg'=> 'Not admin'));
    }

    else{
        // Check connection
    if ($conn->connect_error) {
        die(json_encode(array('msg'=> "Connection failed: " . $conn->connect_error)));
    }
    
    // Escape user input for security (assuming POST data is used directly)
    $table_name = $_GET['tablename'];

    $id = $_GET['id'];
    $key = '';
    $sql = "";
    if($table_name=='Review_table'){
        $key = 'review_id';
        $sql = "DELETE from Review_table where $key = '$id'";
    }
    elseif($table_name== 'user_details'){
        $key = 'user_id' ;
        $sql = "DELETE rt.* from Review_table rt where rt.user_id = '$id'; DELETE bd.* from booking_details bd where bd.user_id = '$id' or bd.hostel_id = (select tt.hostel_id from hostel_details tt where tt.user_id = '$id');  DELETE rd.* from room_details rd where rd.hostel_id = ( SELECT t.hostel_id from hostel_details t where t.user_id = '$id'); DELETE hd.* from hostel_details hd where hd.user_id = '$id'; DELETE ud.* from user_details ud where ud.user_id = '$id'";

    }
    elseif($table_name== 'hostel_details'){
        $key = 'hostel_id';
        $sql = "DELETE rt.* from Review_table rt where rt.hostel_id = '$id'; DELETE bd.* from booking_details bd where bd.hostel_id = '$id';  DELETE rd.* from room_details rd where rd.hostel_id = '$id'; DELETE hd.* from hostel_details hd where hd.hostel_id = '$id'";
    }
    elseif($table_name== 'booking_details'){
        $key = 'booking_id';
        $sql = "DELETE from booking_details where $key = '$id'";

    }
    else{
        http_response_code(400);
        echo json_encode(array('msg'=> 'Invalid request'));
    }

    // echo $table_name;
    if ($conn->multi_query($sql)) {
        http_response_code(204);
        echo json_encode(array('msg'=> "Room deleted successfully"));
    } else {
        http_response_code(500);
        echo json_encode(array('msg'=> "Error deleting row: " . $conn->error));
    }
    
    $conn->close();
    }
    
} else {
    http_response_code(400);
    echo json_encode(array('msg'=> "Method not allowed"));
}
?>