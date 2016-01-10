<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link rel="stylesheet" href="css/main.css" type="text/css" />
        <title>Ticket RAG</title>
    </head>
    <body>
        <div id="page-wrapper">
            <header>
                <a href="settings.php">Settings</a>
                Filter: <select>
                    <option value="all">All</option>
                </select>
            </header>
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
            
            //print_r($PN);

            // Create connection
            $conn = new mysqli('localhost', 'root', '', 'rag');
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            } 
             
            for($i = 0; $i < count($PN); $i++){
                $sql = "INSERT INTO pntickets (pool, ticket_id, last_touched) 
                VALUES('".$PN[$i][0]."', '".$PN[$i][1]."', '".$PN[$i][2]."')";
            
            }
            
            if ($conn->query($sql) === TRUE) {
               echo "New record created successfully";
            } else {
               echo "Error: " . $sql . "<br>" . $conn->error;
            }
            
            $conn->close();
            
            
            ?>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="scripts/main.js"></script>
    </body>
</html>
