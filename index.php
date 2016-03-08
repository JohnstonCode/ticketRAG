<?php
require_once('connect.php');

session_start();



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
    
    $hours = abs($hours);
    $minutes = abs($minutes);
    
    if($minutes < 10)
    {
        $minutes = sprintf("%02d", $minutes);
    }
    
    return $hours . ':' . $minutes;
    }
    else
    {
        return 0;
    }
    
}

$allTables = $conn->query('SHOW TABLES LIKE "%Filter"');

$allTables = mysqli_fetch_array($allTables);

$updatedAt = $conn->query('SELECT * from updateTime');

$updatedAt = $updatedAt->fetch_array(MYSQLI_ASSOC);

$updatedAt['updated_at'] = rtrim($updatedAt['updated_at'], ':00');


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
            <?php 
              if(isset($_SESSION['success']))
              {
                echo '<div class="alert-box success">'. $_SESSION['success'] .'</div>';
                unset($_SESSION['success']);
              }

              if(isset($_SESSION['failure']))
              {
                echo '<div class="alert-box failure">'. $_SESSION['failure'] .'</div>';
                unset($_SESSION['failure']);
              }
            ?>
            <header>
                <a href="settings.php" class="nav-link">Update</a></br>
                <span>Last updated at: <?php echo $updatedAt['updated_at']; ?></span>
                <fieldset>
                    <legend>Filter</legend>
                    Select filter: <select onChange="window.location='?filter='+this.value">
                        <option></option>
                        <?php
                        for($i = 0; $i < count($allTables) - 1; $i++)
                        {
                            echo '<option value="'. str_replace("Filter", "", $allTables[$i]) .'">'. str_replace("Filter", "", $allTables[$i]). '</option>';
                        }
                        ?>
                    </select>
                </fieldset>
            </header>
            <?php
            
            if(isset($_GET['filter']))
            {
                
                $allfilters = [];
    
                foreach($allTables as $value)
                {
                    $allfilters[] = $value;
                }
                
                if (in_array($_GET['filter'] . 'Filter', $allfilters))
                {
                    
                    $PNfilter = $conn->query('SELECT '. $_GET['filter'] .'Filter.pool, '. $_GET['filter'] .'Filter.amber_kpi, '. $_GET['filter'] .'Filter.red_kpi, pntickets.ticket_id, pntickets.last_touched FROM '. $_GET['filter'] .'Filter LEFT JOIN pntickets ON '. $_GET['filter'] .'Filter.pool = pntickets.pool WHERE '. $_GET['filter'] .'Filter.visp = "PN"');
                    $JLPfilter = $conn->query('SELECT '. $_GET['filter'] .'Filter.pool, '. $_GET['filter'] .'Filter.amber_kpi, '. $_GET['filter'] .'Filter.red_kpi, jlptickets.ticket_id, jlptickets.last_touched FROM '. $_GET['filter'] .'Filter LEFT JOIN jlptickets ON '. $_GET['filter'] .'Filter.pool = jlptickets.pool WHERE '. $_GET['filter'] .'Filter.visp = "JLP"');
                    
                    $conn->close();
                    
                    ?>        
                    <table width="100%" style="margin-top: 50px;" class="sort-table">
                        <thead>
                            <tr>
                                <th class="main-table-header" style="font-size: 20px;">Oldest Ticket Report PN</th>
                            </tr>
                            <tr>
                                <th>Pool</th>
                                <th style="cursor: pointer;">Ticket ID</th>
                                <th style="cursor: pointer;">Last Touched</th>
                                <th style="cursor: pointer;">Age (Hours)</th>
                                <th style="cursor: pointer;">Color</th>
                            </tr>
                            <tbody>
                                <?php
                                while($row = mysqli_fetch_array($PNfilter)){
                                ?>
                                <tr>
                                    <td><?php echo $row['pool']?></td>
                                    <td><?php if($row['ticket_id'] == ''){ echo 'Clear!'; }else { echo '<a href="https://workplace.plus.net/tickets/ticket_show.html?ticket_id='. $row['ticket_id'] .'" target="_NEW">'.   $row['ticket_id'].'</a>'; } ?></td>
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
                    <table width="100%" style="margin-top: 50px;" class="sort-table">
                        <thead>
                            <tr>
                                <td class="main-table-header" style="font-size: 20px;">Oldest Ticket Report JLP</td>
                            </tr>
                            <tr>
                                <th>Pool</th>
                                <th>Ticket ID</th>
                                <th>Last Touched</th>
                                <th>Age (Hours)</th>
                                <th>Color</th>
                            </tr>
                            <tbody>
                                <?php
                                while($row = mysqli_fetch_array($JLPfilter)){
                                ?>
                                <tr>
                                    <td><?php echo $row['pool']?></td>
                                    <td><?php if($row['ticket_id'] == ''){ echo 'Clear!'; }else { echo '<a href="https://workplace.plus.net/tickets/ticket_show.html?ticket_id='. $row['ticket_id'] .'" target="_NEW">'.   $row['ticket_id'].'</a>'; } ?></td>
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
        <script src="scripts/jquery.tablesorter.min.js"></script>
        <script src="scripts/main.js"></script>
    </body>
</html>
