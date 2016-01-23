<?php
require_once('connect.php');
require_once('pools.php');

ini_set('memory_limit', '1024M');

$PNpools = [];
$PNamberKpi = [];
$PNredKpi = [];

$JLPpools = [];
$JLPamberKpi = [];
$JLPredKpi = [];

$filter = '';

foreach($_POST as $key => $value){
    
    if(strstr($key, 'visp-pn') == 0)
    {
        $PNpools[] = $key;
    }
    else
    {
        $JLPpools[] = $key;
    }
}

print_r($_POST);

for($i = 0; $i < count($_POST); $i++)
{
    if($i % 3 == 0)
    {
        $PNpools[] = $_POST['filters'][0];
    }
}

$array = json_decode($_POST['filters']);

$filters = array(
    'pool' => array(),
    'amber-kpi' => array(),
    'red-kpi' => array(),
    );
    
$counter = 0;

for($i = 0; $i < count($array); $i++)
{
    if($counter % 3 == 0)
    {
    array_push($filters['pool'], $array[$i]);
    array_push($filters['amber-kpi'], $array[($counter + 1)]);
    array_push($filters['red-kpi'], $array[($counter + 2)]);
    }
    
    $counter++;
}

var_dump($filters);

//$conn->query('TRUNCATE TABLE ' . $filter . 'Filter');

//for($i = 0; $i < count($PNpools); $i++)
//{
    //$sql = "INSERT INTO ".$filter."Filter (visp, pool, amber_kpi, red_kpi) 
    //VALUES('PN', '".$PNpools[$i]."', '".$PNamberKpi[$i]."', '".$PNredKpi[$i]."')";
    
    //if ($conn->query($sql) === TRUE) 
    //{
        //echo "New record created successfully";
    //} else 
    //{
        //echo "Error: " . $sql . "<br>" . $conn->error;
    //}

//}

//for($i = 0; $i < count($JLPpools); $i++)
//{
    //$sql = "INSERT INTO ".$filter."Filter (visp, pool, amber_kpi, red_kpi) 
    //VALUES('JLP', '".$JLPpools[$i]."', '".$JLPamberKpi[$i]."', '".$JLPredKpi[$i]."')";
    
    //if ($conn->query($sql) === TRUE) 
    //{
        //echo "New record created successfully";
    //} else 
    //{
        //echo "Error: " . $sql . "<br>" . $conn->error;
    //}

//}

//$conn->close();