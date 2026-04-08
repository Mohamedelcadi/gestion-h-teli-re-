<?php
include('db_connect.php');

$result = $conn->query("SHOW COLUMNS FROM rooms");
if ($result) {
    while($row = $result->fetch_assoc()) {
        echo $row['Field'] . " - " . $row['Type'] . "\n";
    }
} else {
    echo "Error: " . $conn->error;
}
?> 