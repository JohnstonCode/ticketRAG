<?php
require_once('connect.php');
function hoursDiff($ticketAge)
{
    if($ticketAge != '')
    {
    $timeNow = date('Y-m-d h:m:s');
    
    $ticketAge = strtotime($ticketAge);
    $timeNow = strtotime($timeNow);
    
    $diff = $timeNow - $ticketAge;
    
    $hours = floor($diff/3600);
    
    $minutes = floor(($diff%3600)/60);
    
    return $hours . ':' . $minutes;
    }
    else
    {
        return 0;
    }
    
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
                <a href="settings.php">Settings</a></br>
                Select filter to edit: <select onChange="window.location='?filter='+this.value">
                    <option></option>
                    <option value="faults">Faults</option>
                    <option value="test">Test</option>
                </select>
            </header>
            <?php
            
            if(isset($_GET['filter']))
            {
                $allTables = $conn->query('SHOW TABLES LIKE "%Filter"');
                
                $allfilters = [];
    
                while($row = mysqli_fetch_array($allTables))
                {
                    $allfilters[] = $row['Tables_in_rag (%Filter)'];
                }
                
                if (in_array($_GET['filter'] . 'Filter', $allfilters))
                {
                    
                    $PNfilter = $conn->query('SELECT '. $_GET['filter'] .'Filter.pool, '. $_GET['filter'] .'Filter.amber_kpi, '. $_GET['filter'] .'Filter.red_kpi, pntickets.ticket_id, pntickets.last_touched FROM '. $_GET['filter'] .'Filter LEFT JOIN pntickets ON '. $_GET['filter'] .'Filter.pool = pntickets.pool ORDER BY '. $_GET['filter'] .'Filter.pool');
                    $JLPfilter = $conn->query('SELECT '. $_GET['filter'] .'Filter.pool, '. $_GET['filter'] .'Filter.amber_kpi, '. $_GET['filter'] .'Filter.red_kpi, jlptickets.ticket_id, jlptickets.last_touched FROM '. $_GET['filter'] .'Filter LEFT JOIN jlptickets ON '. $_GET['filter'] .'Filter.pool = jlptickets.pool ORDER BY '. $_GET['filter'] .'Filter.pool');
                    
                    ?>        
                    <table width="100%">
                        <thead>
                            <tr>
                                <td class="main-table-header">Oldest Ticket Report PN</td>
                            </tr>
                            <tr>
                                <td>Pool</td>
                                <td>Ticket ID</td>
                                <td>Last Touched</td>
                                <td>Age (Hours)</td>
                                <td>Color</td>
                            </tr>
                            <tbody>
                                <?php
                                while($row = mysqli_fetch_array($PNfilter)){
                                ?>
                                <tr>
                                    <td><?php echo $row['pool']?></td>
                                    <td><?php if($row['ticket_id'] == ''){ echo 'Clear!'; }else { echo $row['ticket_id']; } ?></td>
                                    <td><?php if($row['last_touched'] != ''){ echo $row['last_touched']; } ?></td>
                                    <td><?php if($row['last_touched'] != ''){ echo hoursDiff($row['last_touched']); } ?></td>
                                    <td><?php if(hoursDiff($row['last_touched']) < intval($row['amber_kpi'])){ echo 'Green'; }elseif(hoursDiff($row['last_touched']) < intval($row['red_kpi'])){ echo 'Amber'; }else { echo 'Red'; } ?></td>
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
                                <td class="main-table-header">Oldest Ticket Report JLP</td>
                            </tr>
                            <tr>
                                <td>Pool</td>
                                <td>Ticket ID</td>
                                <td>Last Touched</td>
                                <td>Age (Hours)</td>
                                <td>Color</td>
                            </tr>
                            <tbody>
                                <?php
                                while($row = mysqli_fetch_array($JLPfilter)){
                                ?>
                                <tr>
                                    <td><?php echo $row['pool']?></td>
                                    <td><?php if($row['ticket_id'] == ''){ echo 'Clear!'; }else { echo $row['ticket_id']; } ?></td>
                                    <td><?php if($row['last_touched'] != ''){ echo $row['last_touched']; } ?></td>
                                    <td><?php if($row['last_touched'] != ''){ echo hoursDiff($row['last_touched']); } ?></td>
                                    <td><?php if(hoursDiff($row['last_touched']) < intval($row['amber_kpi'])){ echo 'Green'; }elseif(hoursDiff($row['last_touched']) < intval($row['red_kpi'])){ echo 'Amber'; }else { echo 'Red'; } ?></td>
                                </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </thead>
                    </table>
                    <?php
                }
            }    
            
            ?>
        </div><!-- END of page wrapper -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="scripts/main.js"></script>
    </body>
</html>
