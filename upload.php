<?php

   require_once('csv.php');
   require_once('connect.php');

   session_start();

   if(isset($_FILES['report'])){
      $errors= array();
      $file_name = $_FILES['report']['name'];
      $file_tmp =$_FILES['report']['tmp_name'];
      $file_type=$_FILES['report']['type'];
      $file_ext=strtolower(end(explode('.',$_FILES['report']['name'])));
      
      $expensions= array("csv");
      
      if(in_array($file_ext,$expensions)=== false){
         $errors[]="extension not allowed";
      }
      
      if(empty($errors)==true){
         move_uploaded_file($file_tmp,"uploads/".$file_name);
         $csv = new CSV($conn);
         $reports = $csv->convertCSV();
        
         if($csv->moveToDB($reports[0], 'pntickets') == true && $csv->moveToDB($reports[1], 'jlptickets') == true)
         {
            $_SESSION['success'] = "File uploaded";
            header('Location: index.php');
         }
      }
      else
      {
         $_SESSION['failure'] = "Error uploading file";
         header('Location: settings.php');
      }
   }
?>