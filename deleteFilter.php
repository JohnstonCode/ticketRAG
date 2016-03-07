<?php
require_once('connect.php');

session_start();

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
  
  if($_POST['filter-to-remove'])
  {
    
    $filter = filter_var($_POST['filter-to-remove'], FILTER_SANITIZE_STRING);
    
    $sql = "DROP TABLE ". $filter ."Filter";
    
    if ($conn->query($sql) === TRUE) 
    {
        $_SESSION['success'] = "Filter removed";
        header('Location: settings.php');
        die();
    } 
    else 
    {
        $_SESSION['failure'] = "Error removing filter";
        header('Location: settings.php');
        die();
    }

    $conn->close();
    
  }
  
  
  
}


?>