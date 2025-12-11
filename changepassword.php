<?php
include('db_connection.php');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }
    $email = $_POST['email'];
    $newpassword = $_POST['password'];
    $sql = "UPDATE user_details Set `password` = '$newpassword' where `email` = '$email'";
    $result = $conn->query($sql);
?>