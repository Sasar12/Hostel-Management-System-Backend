<?php
// require_once'vendor/autoload.php';

// use Firebase\JWT\JWT;
// $error ='';

require_once 'Jwt.php';

$config = require_once'config.php';
$secret_key = $config['jwt-secret'];

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if all required fields are present
    if (isset($_POST['email']) && isset($_POST['user_type']) && isset($_POST['password'])) {
       
        
        // Connect to your MySQL database
        $servername = "localhost"; // Change this to your database server name
        $username = "root"; // Change this to your database username
        $password_db = ""; // Change this to your database password
        $dbname = "Final_project"; // Change this to your database name

        $conn = new mysqli($servername, $username, $password_db, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
         // Retrieve POST data
         $email = $_POST['email'];
         $user_type = $_POST['user_type'];
         $password = $_POST['password'];

        // Prepare SQL statement to fetch user details
        $sql = "SELECT user_id,email,user_type,password FROM user_details WHERE email = '$email' AND user_type = '$user_type' AND password = '$password'";
        $result = $conn->query($sql);

        // Check if user exists with provided credentials
        if ($result->num_rows > 0) {
            // User found, return success
            while($row = $result->fetch_assoc()){
            $user_id = $row["user_id"];
            $res = $row['email'];
            $user = $row['user_type'];
            if (($email == $res) && ($user_type == $user)) {
       
            $data = array("email"=> $res,"user_type"=> $user,"user_id"=> $user_id);
            header('Content-Type: application/json; charset=utf-8');
    
            $JwtController = new Jwt($secret_key);

            $payload = [
                "user_id"=> $user_id
            ];
                
            $token = $JwtController->encode($payload);
            $sql = "UPDATE user_details ud SET ud.api_key = '$token' where ud.user_id = '$user_id'";
            $result = $conn->query($sql);
            
            http_response_code(200);
            echo json_encode(["token"=>$token, "user_type"=>$user_type]);
            break;
            }
        }
        } else {
            // No user found with provided credentials, return error
            http_response_code(404);
            echo json_encode(array('msg'=>"Invalid username and password"));
        }

        // Close database connection
        $conn->close();
    } else {
        // Required fields are missing, return error
        echo "error";
    }
} else {
    // Invalid request method, return error
    echo "invalid method";
}
?>



