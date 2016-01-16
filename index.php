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
    
    return $hours;
    }
    else
    {
        return 0;
    }
    
}
function minsDiff($ticketAge)
{
    $timeNow = date('Y-m-d h:m:s');
    
    $ticketAge = strtotime($ticketAge);
    $timeNow = strtotime($timeNow);
    
    $diff = $timeNow - $ticketAge;
    
    $minutes = floor(($diff%3600)/60);
    
    return $minutes;
    
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
                    
                    $PNPools = [];
                    $PNTicketID = [];
                    $PNLastTouched = [];
                    $PNAmberKpi = [];
                    $PNRedKpi = [];
                    
                    while($row = mysqli_fetch_array($PNfilter))
                    {
                        $PNPools[] = $row['pool'];
                        $PNTicketID[] = $row['ticket_id'];
                        $PNLastTouched[] = $row['last_touched'];
                        $PNAmberKpi[] = $row['amber_kpi'];
                        $PNRedKpi[] = $row['red_kpi'];
                    }
                    
                    $JLPPools = [];
                    $JLPTicketID = [];
                    $JLPLastTouched = [];
                    $JLPAmberKpi = [];
                    $JLPRedKpi = [];
                    
                    while($row = mysqli_fetch_array($JLPfilter))
                    {
                        $JLPPools[] = $row['pool'];
                        $JLPTicketID[] = $row['ticket_id'];
                        $JLPLastTouched[] = $row['last_touched'];
                        $JLPAmberKpi[] = $row['amber_kpi'];
                        $JLPRedKpi[] = $row['red_kpi'];
                    }
                    
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
                                for($i = 0; $i < count($PNPools); $i++) {
                                ?>
                                <tr>
                                    <td><?php echo $PNPools[$i]?></td>
                                    <td><?php if($PNTicketID[$i] == ''){ echo 'Clear!'; }else { echo $PNTicketID[$i]; } ?></td>
                                    <td><?php if($PNLastTouched[$i] != ''){ echo $PNTicketID[$i]; } ?></td>
                                    <td><?php if($PNLastTouched[$i] != ''){ echo hoursDiff($PNLastTouched[$i]) . ':' . minsDiff($PNLastTouched[$i]); } ?></td>
                                    <td><?php if(hoursDiff($PNLastTouched[$i]) < intval($PNAmberKpi[$i])){ echo 'Green'; }elseif(hoursDiff($PNLastTouched[$i]) < intval($PNRedKpi[$i])){ echo 'Amber'; }else { echo 'Red'; } ?></td>
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
                                for($i = 0; $i < count($JLPPools); $i++) {
                                ?>
                                <tr>
                                    <td><?php echo $JLPPools[$i]?></td>
                                    <td><?php if($JLPTicketID[$i] == ''){ echo 'Clear!'; }else { echo $JLPTicketID[$i]; } ?></td>
                                    <td><?php if($JLPLastTouched[$i] != ''){ echo $JLPTicketID[$i]; } ?></td>
                                    <td><?php if($JLPLastTouched[$i] != ''){ echo hoursDiff($JLPLastTouched[$i]); } ?></td>
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
