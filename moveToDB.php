<?php
            
$csv = array_map('str_getcsv', file('uploads/OldestTicketReport.csv'));

//print_r($csv);

$PN = array();
$JLP = array();

$startValue = 'Oldest ticket report PN';
$endValue = 'Oldest ticket report MAAF';

$startIndex = 0;
foreach ( $csv as $index => $value ) {
    if ( $value[0] === $startValue ) {
        $startIndex = $index;
    } else
    if ( $value[0] === $endValue ) {
        $PN[] = array_slice($csv, $startIndex + 2, $index - $startIndex - 3);
        $JLP = array_slice($csv, $index + 5);
    }
}

$PN = $PN[0];


function moveToDB($data, $table)
{
    
    //Create connection
    $conn = new mysqli('localhost', 'root', '', 'rag');
    //Check connection
    if($conn->connect_error)
    {
        die('Connection failed: ' . $conn->connect_error);
    }
    
    for($i = 0; $i < count($data); $i++)
    {
        $sql = $sql = "INSERT INTO '".$table."' (pool, ticket_id, last_touched) 
        VALUES('".$data[$i][0]."', '".$data[$i][1]."', '".$data[$i][2]."')";
    }
    
    if($conn->query($sql) === TRUE)
    {
        echo 'New records added successfully';
    }
    else 
    {
        echo 'Error: ' . $sql . '</br>' . $conn->error . '</br>';
    }
    
    $conn->close();
    
}



?>