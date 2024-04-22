<?php
require('../inc/dbconn.php');
function getStudents()
{
    global $conn;
    $query = "SELECT * FROM student";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        if (mysqli_num_rows($query_run) > 0) {
            $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
            $data = [
                'status' => 200,
                'message' => 'Success',
                'customers' => $res
            ];
            header('HTTP/1.0 200 Success');
            return json_encode($data);
        } else {
            $data = [
                'status' => 404,
                'message' => 'No Student Found'
            ];
            header('HTTP/1.0 404 No Student Found');
            return json_encode($data);
        }
    } else {
        $data = [
            'status' => 500,
            'message' => 'Internal Server Error'
        ];
        header('HTTP/1.0 500 Internal Server Error');
        return json_encode($data);
    }
}


function addStudent($inputData)
{
    global $conn;
    $json_data = file_get_contents("php://input");
    $user_data = json_decode($json_data, true);
    $name = $user_data['name'];
    $roll_no = $user_data['roll_no'];
    $course = $user_data['course'];
    $subject_marks = json_encode($user_data['subject_marks']);
    
    if (empty(trim($name))) {
        return error422("Student name is required");
    } elseif (empty(trim($roll_no))) {
        return error422("Student's roll number is required");
    } elseif (empty(trim($course))) {
        return error422("Course name is required");
    }
    elseif (empty(trim($subject_marks))) {
        return error422("Entry Your Subject name and marks");
    }
    else {             
        $query = "INSERT INTO student(name,roll_no,course, subject_marks) VALUES ('$name', '$roll_no','$course', '$subject_marks') ";
        $my_query = mysqli_query($conn, $query);

        if ($my_query) {
            $data = [
                'status' => 201,
                'message' => 'Student info added successfully'
            ];
            header('HTTP/1.0 201 Added');
            echo json_encode($data);
        } else {
            $data = [
                'status' => 500,
                'message' => "Internal Server Error",
            ];
            header('HTTP/1.0 500 Internal Server Error');
            return json_encode($data);
        }
    }
}

function error422($message)
{
    $data = [
        'status' => 422,
        'message' => $message,
    ];
    header('HTTP/1.0 422 Unprocessable Entity');
    echo json_encode($data);
    exit();
}