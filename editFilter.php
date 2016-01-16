<?php
require_once('connect.php');

$pools = [];
$amberKpi = [];
$redKpi = [];
$filter = '';

foreach($_POST as $key => $value){
    if($value == 'on')
    {
        $pools[] = str_replace("_", " ", $key);
    }
    
    if($value != 'on' and $value != '')
    {
        if(strpos($key,'amber-kpi') != false)
        {
            $amberKpi[] = $value;
        }
        else
        {
            $redKpi[] = $value;
        }
    }
    
    if(strpos($key,'amber-kpi') == false and strpos($key,'red-kpi') == false and $value != 'on')
    {
        $filter = $key;
    }
}

$conn->query('TRUNCATE TABLE ' . $filter . 'Filter');

for($i = 0; $i < count($pools); $i++)
{
    $sql = "INSERT INTO ".$filter."Filter (pool, amber_kpi, red_kpi) 
    VALUES('".$pools[$i]."', '".$amberKpi[$i]."', '".$redKpi[$i]."')";
    
    if (!$conn->query($sql))
      {
      echo("Error description: " . mysqli_error($con));
      }
    
}

$conn->close();