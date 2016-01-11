<?php

   require_once('csv.php');

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
         $reports = CSV::convertCSV();
         CSV::moveToDB($reports[0], 'pntickets');
         csv::moveToDB($reports[1], 'jlptickets');
      }else{
         print_r($errors);
      }
   }
?>