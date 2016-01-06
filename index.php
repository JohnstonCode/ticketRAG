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
            $row = 1;
            if (($handle = fopen('uploads/OldestTicketReport.csv', 'r')) !== FALSE)
            {
                echo '<table style="width:100%">';
            
                // Get the rest
                while (($data = fgetcsv($handle, 1000, ',')) !== FALSE)
                {
                    echo '<tr><td>'.implode('</td><td>', $data).'</td></tr>';
                }
                fclose($handle);
                echo '</table>';
            }
            ?>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="scripts/main.js"></script>
    </body>
</html>
