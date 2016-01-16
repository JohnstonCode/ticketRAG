<?php
require_once('connect.php');

$filterName = $_POST['filter-name'];


// sql to create table
$sql = "CREATE TABLE ". $filterName . "Filter(
id INT(255) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
pool VARCHAR(255) NOT NULL,
amber_kpi INT(2) NOT NULL,
red_kpi INT(2)
)";

if ($conn->query($sql) === TRUE) {
    echo "Filter ". $filterName ." created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>