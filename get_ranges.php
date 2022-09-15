<?php
header('Access-Control-Allow-Origin: *');
//header('Content-Type: application/json');
header('Content-Type: text/plain');


include('consts.php');


$conn = new mysqli(CREDS::SERVERNAME, CREDS::USERNAME, CREDS::PASSWORD, CREDS::DATABASE);

if ($conn->connect_error) {
    die();
}

$data = array();
foreach ($columns as $column) {
    $query = "SELECT MIN($column), MAX($column) FROM event_database";
    $result = $conn->query($query)->fetch_row();
    $data[$column] = $result;
}

echo json_encode($data);
