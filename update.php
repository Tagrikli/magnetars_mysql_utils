<?php
header("Content-Type: text/plain");
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

include("queries.php");
include("consts.php");
include("utils.php");


$conn = new mysqli(CREDS::SERVERNAME, CREDS::USERNAME, CREDS::PASSWORD, CREDS::DATABASE);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connection succesful.\n";


if ($conn->query(QUERY::CREATE_TABLE()) === TRUE) {
    echo "Table created.\n";
}


$result = $conn->query(QUERY::SELECT_FILENAMES());

echo "Total records count: " . $result->num_rows . "\n";

$filenames = array();
while ($row = $result->fetch_assoc()) {
    array_push($filenames, name_base($row["filename"]));
}


$query_prefix = QUERY::INSERT_RECORD();

$total_inserted = 0;
$objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('../VEGA_DATA'));
foreach ($objects as $object) {
    $filename = $object->getRealPath();
    $filename_base = basename(name_base($filename));

    if (str_ends_with($filename, '.json') && (!in_array($filename_base, $filenames))) {


        $data = file_get_contents($filename);
        $obj = json_decode($data);


        $query_postfix = preparePostfix($obj);

        $query_full =  $query_prefix . " ( " . $query_postfix . ")";


        $conn->query($query_full);

        if ($conn->errno != 0) {
            echo "[ERROR] Filename: ". $filename . " Error No: " . $conn->errno . " Message: " . $conn->error;
        } else {
            $total_inserted++;
        }
    }
}

echo "Newly inserted record count: " . $total_inserted . "\n";




$conn->close();

echo "Done :) Have a nice day!";
