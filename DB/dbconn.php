<?php
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "student_course_marks";

    $conn = mysqli_connect($host, $username, $password, $dbname);
    
    if(!$conn){
        die("Not connected: ". mysqli_connect_error());
    }
    // echo "Connected";
?>