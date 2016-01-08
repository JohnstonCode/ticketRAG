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
            
            var_dump($csv);
            
            $dest = array();

            $startValue = 'Oldest ticket report PN';
            $endValue = 'Oldest ticket report MAAF';
            
            $startIndex = 0;
            foreach ( $csv as $index => $value ) {
                if ( $value[0] === $startValue ) {
                    $startIndex = $index;
                } else
                if ( $value[0] === $endValue ) {
                    $dest[] = array_slice($csv, $startIndex, $index - $startIndex + 1);
                }
            }
            
            print_r($dest);
            
            
            
            ?>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="scripts/main.js"></script>
    </body>
</html>
