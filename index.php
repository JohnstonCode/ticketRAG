<?php
require_once('pools.php');
require_once('connect.php');

$PNQuery = $conn->query('SELECT * FROM pntickets');
$JLPQuery = $conn->query('SELECT * FROM jlptickets');

function hoursDiff($ticketAge)
{
    $timeNow = date('Y-m-d h:m:s');
    
    $ticketAge = strtotime($ticketAge);
    $timeNow = strtotime($timeNow);
    
    $diff = $timeNow - $ticketAge;
    
    $hours = floor($diff/3600);
    
    $minutes = floor(($diff%3600)/60);
    
    return $hours . ':' . $minutes;
    
}

$PNpools = [];
$PNticketID = [];
$PNlastTouched = [];

while($row = mysqli_fetch_array($PNQuery))
{
    $PNpools[] = $row['pool'];
    $PNticketID[] = $row['ticket_id'];
    $PNlastTouched[] = $row['last_touched'];

}

$JLPpools = [];
$JLPticketID = [];
$JLPlastTouched = [];

while($row = mysqli_fetch_array($JLPQuery))
{
    $JLPpools[] = $row['pool'];
    $JLPticketID[] = $row['ticket_id'];
    $JLPlastTouched[] = $row['last_touched'];

}

//SELECT faultsFilter.pool, faultsFilter.amber_kpi, faultsFilter.red_kpi, pntickets.ticket_id, pntickets.last_touched
//FROM faultsFilter
//LEFT JOIN pntickets ON faultsFilter.pool = pntickets.pool
//ORDER BY faultsFilter.pool

$conn->close();
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
                Select filter to edit: <select onChange="window.location='settings.php?filter='+this.value">
                    <option></option>
                    <option value="faults">Faults</option>
                    <option value="test">Test</option>
                </select>
            </header>
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
                    </tr>
                    <tbody>
                        <?php
                        for($i = 0; $i < count($allPNPools); $i++) {
                        ?>
                        <tr>
                            <td><?php echo $allPNPools[$i]?></td>
                            <td><?php if(in_array($allPNPools[$i], $PNpools)){ $pos = array_search($allPNPools[$i], $PNpools); echo $PNticketID[$pos]; }else { echo 'Clear!'; } ?></td>
                            <td><?php if(in_array($allPNPools[$i], $PNpools)){ $pos = array_search($allPNPools[$i], $PNpools); echo $PNlastTouched[$pos]; } ?></td>
                            <td><?php if(in_array($allPNPools[$i], $PNpools)){ $pos = array_search($allPNPools[$i], $PNpools); echo hoursDiff($PNlastTouched[$pos]); } ?></td>
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
                        <td class="main-table-header">Oldest Ticket Report JLB</td>
                    </tr>
                    <tr>
                        <td>Pool</td>
                        <td>Ticket ID</td>
                        <td>Last Touched</td>
                        <td>Age (Hours)</td>
                    </tr>
                    <tbody>
                        <?php
                        for($i = 0; $i < count($allJLPPools); $i++) {
                        ?>
                        <tr>
                            <td><?php echo $allJLPPools[$i]?></td>
                            <td><?php if(in_array($allJLPPools[$i], $JLPpools)){ $pos = array_search($allJLPPools[$i], $JLPpools); echo $JLPticketID[$pos]; }else { echo 'Clear!'; } ?></td>
                            <td><?php if(in_array($allJLPPools[$i], $JLPpools)){ $pos = array_search($allJLPPools[$i], $JLPpools); echo $JLPlastTouched[$pos]; } ?></td>
                            <td><?php if(in_array($allJLPPools[$i], $JLPpools)){ $pos = array_search($allJLPPools[$i], $JLPpools); echo hoursDiff($JLPlastTouched[$pos]); } ?></td>
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
