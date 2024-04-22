<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type:application/json');
header('Access-Control-Allow-Method: GET');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
include ('logic.php');
$requestMethod = $_SERVER['REQUEST_METHOD'];

if($requestMethod == 'POST'){
    $inputData = json_decode(file_get_contents("php://input"), true);
    // echo "$inputData";
    if(empty($inputData) ){ $storeUser = addStudent($_POST);}
    else {$storeUser = addStudent($inputData);}
    echo $storeUser;
}
else{
    $data=[
        'status' => 405,
        'message' => $requestMethod. ' Method Not Allowed'
    ];
    header('HTTP/1.1 405 Method Not Allowed');
    echo json_encode($data);
}
?>