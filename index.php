<?php
//Create connection
$conn = new mysqli('localhost', 'root', '', 'rag');
//Check connection
if($conn->connect_error)
{
    die('Connection failed: ' . $conn->connect_error);
}

$PNQuery = $conn->query('SELECT * FROM pntickets');
$JLPQuery = $conn->query('SELECT * FROM jlptickets');

function hoursDiff($ticketAge)
{
    $timeNow = date('Y-m-d h:m:s');
    
    $ticketAge = strtotime($ticketAge);
    $timeNow = strtotime($timeNow);
    
    $diff = $timeNow - $ticketAge;
    
    $hours = $diff / 60 / 60;
    
    $hours = floor($hours);
    
    return $hours;
    
}

?>
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
            <table width="100%">
                <thead>
                    <tr>
                        <td>Oldest Ticket Report PN</td>
                    </tr>
                    <tr>
                        <td>Pool</td>
                        <td>Ticket ID</td>
                        <td>Last Touched</td>
                        <td>Age (Hours)</td>
                    </tr>
                    <tbody>
                        <?php
                            while($row = mysqli_fetch_assoc($PNQuery)) {
                        ?>
                        <tr>
                            <td><?php echo $row['pool']?></td>
                            <td><?php echo $row['ticket_id']?></td>
                            <td><?php echo $row['last_touched']?></td>
                            <td><?php echo hoursDiff($row['last_touched']) ?></td>
                        </tr>
        
                        <?php
                        }
                        ?>
                    </tbody>
                </thead>
            </table>
            <table width="100%">
                <thead>
                    <tr>
                        <td>Oldest Ticket Report JLB</td>
                    </tr>
                    <tr>
                        <td>Pool</td>
                        <td>Ticket ID</td>
                        <td>Last Touched</td>
                        <td>Age (Hours)</td>
                    </tr>
                    <tbody>
                        <?php
                            while($row = mysqli_fetch_assoc($JLPQuery)) {
                        ?>
                        <tr>
                            <td><?php echo $row['pool']?></td>
                            <td><?php echo $row['ticket_id']?></td>
                            <td><?php echo $row['last_touched']?></td>
                            <td><?php echo hoursDiff($row['last_touched']) ?></td>
                        </tr>
        
                        <?php
                        }
                        ?>
                    </tbody>
                </thead>
            </table>
        </div><!-- END of page wrapper -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="scripts/main.js"></script>
    </body>
</html>
