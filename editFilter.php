<?php
require_once('connect.php');
require_once('pools.php');

$filter = array_keys($_POST);
$filter = $filter[0];

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

$PNpools = [];
$PNamberKpi = [];
$PNredKpi = [];

$JLPpools = [];
$JLPamberKpi = [];
$JLPredKpi = [];

for($i = 0; $i < count($filters['pool']); $i++)
{
    if(strpos($filters['pool'][$i], 'pn') !== false)
    {
        $PNpools[] = str_replace("visp-pn-", "", $filters['pool'][$i]);
        $PNamberKpi[] = $filters['amber-kpi'][$i];
        $PNredKpi[] = $filters['red-kpi'][$i];
    }
    elseif(strpos($filters['pool'][$i], 'jlp') !== false)
    {
        $JLPpools[] = str_replace("visp-jlp-", "", $filters['pool'][$i]);
        $JLPamberKpi[] = $filters['amber-kpi'][$i];
        $JLPredKpi[] = $filters['red-kpi'][$i];
    }
}

var_dump($JLPpools);
var_dump($JLPamberKpi);
var_dump($JLPredKpi);

$conn->query('TRUNCATE TABLE ' . $filter . 'Filter');

for($i = 0; $i < count($PNpools); $i++)
{
    $sql = "INSERT INTO ".$filter."Filter (visp, pool, amber_kpi, red_kpi) 
    VALUES('PN', '".$PNpools[$i]."', '".$PNamberKpi[$i]."', '".$PNredKpi[$i]."')";
    
    if ($conn->query($sql) === TRUE) 
    {
        echo "New record created successfully";
    } else 
    {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

}

for($i = 0; $i < count($JLPpools); $i++)
{
    $sql = "INSERT INTO ".$filter."Filter (visp, pool, amber_kpi, red_kpi) 
    VALUES('JLP', '".$JLPpools[$i]."', '".$JLPamberKpi[$i]."', '".$JLPredKpi[$i]."')";
    
    if ($conn->query($sql) === TRUE) 
    {
        echo "New record created successfully";
    } else 
    {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

}

$conn->close();