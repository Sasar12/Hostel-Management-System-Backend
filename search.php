
<?php
// parse_str(parse_url($_SERVER['REQUEST_URI'],  -1)['query'], $params);
error_reporting(0);

include('db_connection.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$searchdata = $conn->real_escape_string($_GET['hostel_name']);

// Using prepared statements to prevent SQL injection
$stmt = $conn->prepare("SELECT DISTINCT ud.hostel_name, ud.average_rating, ud.hostel_id,(SELECT GROUP_CONCAT(DISTINCT rd.room_image)
        FROM room_details rd
        WHERE rd.hostel_id = ud.hostel_id
        AND rd.room_image <> '') as room_images, (SELECT COUNT(rt.hostel_id) FROM `Review_table` rt inner join hostel_details hd on hd.hostel_id = rt.hostel_id WHERE hd.hostel_address LIKE '%$searchdata%' OR hd.hostel_name LIKE '%$searchdata%') as total_reviews FROM hostel_details ud  WHERE ud.hostel_address LIKE '$searchdata%' OR ud.hostel_name LIKE '$searchdata%'");
// $searchParam = "%$searchdata%";  // Assuming you want to match partially

// $stmt->bind_param("ss", $searchParam, $searchParam);
$stmt->execute();

$result = $stmt->get_result();

$response = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $res = $row['hostel_name'];
        $temp['hostel_name'] = $res;
        $res1 = $row['average_rating'];
        $temp['hostel_id'] = $row['hostel_id'];
       
        if($row['room_images']!=null){
            $temp['room_images'] = explode(",",$row['room_images']);

        }
        else{
            $temp['room_images'] = [];

        }

        
        $temp['average_rating'] = $res1;
        $temp['total_reviews'] = $row['total_reviews'];
        // Check if the hostel_name is already in the response array
        if (!in_array($res, $response)) {
            array_push($response, $temp);
        }
    }
}

echo json_encode($response);

$stmt->close();
$conn->close();
?>
