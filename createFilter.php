<?php
require_once('connect.php');

session_start();

$filterName = $_POST['filter-name'];

if($filterName != '')
{
  // sql to create table
  $sql = "CREATE TABLE ". $filterName . "Filter(
  id INT(255) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
  pool VARCHAR(255) NOT NULL,
  amber_kpi INT(2) NOT NULL,
  red_kpi INT(2)
  )";

  if ($conn->query($sql) === TRUE) 
  {
      $_SESSION['success'] = "Created filter";
      header('Location: settings.php');
      die();
  } 
  else 
  {
      $_SESSION['failure'] = "Error creating filter";
      header('Location: settings.php');
      die();
  }

  $conn->close();
}
?>