<?php
include('db_connect.php');

$result = $conn->query("SELECT * FROM rooms LIMIT 1");
if ($result) {
    $row = $result->fetch_assoc();
    if ($row) {
        foreach ($row as $column => $value) {
            echo $column . "\n";
        }
    } else {
        echo "No data found in rooms table";
    }
} else {
    echo "Error: " . $conn->error;
}
?> 