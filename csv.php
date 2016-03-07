<?php

class CSV
{
  
    private $conn = null;
    
    public function __construct($conn)
    {
      
      $this->conn = $conn;
      
    }  
    
    public function convertCSV()
    {
        //empty array for the return
        $reports = [];
        
        //convert CSV file into one array
        $csv = array_map('str_getcsv', file('uploads/OldestTicketReport.csv'));

        //declare empty arrays for split
        $PN = array();
        $JLP = array();
        
        $startValue = 'Oldest ticket report PN'; //where the loop starts
        $endValue = 'Oldest ticket report MAAF'; //where the loop ends
        
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
        
        $PN = $PN[0]; //remove the outermost array
        
        $reports[0] = $PN;
        $reports[1] = $JLP;
        
        return $reports;
        
    }
    
    public function moveToDB($data, $table)
    {
        
        $this->conn->query('TRUNCATE TABLE ' . $table);
        
        date_default_timezone_set('GMT');
        $currentTime = date("h:i");
      
        $updateTime = "UPDATE updateTime SET updated_at = '". $currentTime ."'";
      
        $this->conn->query($updateTime);
      
        for($i = 0; $i < count($data); $i++)
        {
            $sql = "INSERT INTO ".$table." (pool, ticket_id, last_touched) 
            VALUES('".$data[$i][0]."', '".$data[$i][1]."', '".$data[$i][2]."')";
            
            $this->conn->query($sql);
            
        }
        
        if($this->conn->query($sql) === TRUE)
        {
            header("Location: /");
            die();
        }
        else 
        {
            echo 'Error: ' . $sql . '</br>' . $this->conn->error . '</br>';
        }
        
        $this->conn->close();
        
    }
    
}