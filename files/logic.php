<?php
require('../inc/dbconn.php');
function getStudents()
{
    global $conn;
    $query = "SELECT * FROM Student";
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
            header('HTTP/1.0 404 No Studnet Found');
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


function addData($inputData)
{
    global $conn;
    $name = mysqli_real_escape_string($conn, $inputData['name']);
    $mobile = mysqli_real_escape_string($conn, $inputData['mobile']);
    $course = mysqli_real_escape_string($conn, $inputData['course']);

    if (empty(trim($name))) {
        return error422("Policy Not selected");
    } elseif (empty(trim($mobile))) {
        return error422("Add your members");
    }else {
        if ($policy === 'CareSupreme') {
            $policyAmoutQuery = "SELECT amount FROM PolicyInfo WHERE policy='CareSupreme'";
            $course = "SELECT amount FROM member_info WHERE members ='$members'";
            $result11 = mysqli_query($conn, $policyAmoutQuery); 
            $result12 = mysqli_query($conn, $course);
            if ($result11 && $result12) {
                $policyAmount = mysqli_fetch_assoc($result11);
                $memberAmount = mysqli_fetch_assoc($result12);
                $amount = $policyAmount['amount'] + $memberAmount['amount'];
                echo $policyAmount['amount'];
                echo $memberAmount['amount'];
                echo "Hello";
                echo $amount;
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        
        } else {      
            $policyAmoutQuery = "SELECT amount FROM PolicyInfo WHERE policy='CareAdvantage'";
            $memberAmountQuery = "SELECT amount FROM member_info WHERE members ='$members'";
            $result11 = mysqli_query($conn, $policyAmoutQuery); 
            $result12 = mysqli_query($conn, $memberAmountQuery);
            if ($result11 && $result12) {
                $policyAmount = mysqli_fetch_assoc($result11);
                $memberAmount = mysqli_fetch_assoc($result12);
                $amount = $policyAmount['amount'] + $memberAmount['amount'];
                echo $policyAmount['amount'];
                echo $memberAmount['amount'];
                echo "Hello";
                echo $amount;
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        }
        
        $mem_details = [
            'Member_Name' => $members,
            'Age' =>$age
        ]; 
        $members_details = json_encode($mem_details);        
        $query = "INSERT INTO api(policy, mobile, pincode, amount, members) VALUES ('$policy', '$mobile','$pincode', '$amount', '$members_details') ";
        $my_query = mysqli_query($conn, $query);

        if ($my_query) {
            $data = [
                'status' => 201,
                'message' => 'User info added successfully'
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