<?php
require_once('pools.php');
require_once('connect.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link rel="stylesheet" href="css/main.css" type="text/css" />
        <title>Ticket RAG | Settings</title>
    </head>
    <body>
        <section>
            <form action="upload.php" method="post" enctype="multipart/form-data">
                Select NOC report: <input type="file" name="report">
                <input type="submit" value="Upload" name="submit">
            </form>
        </section>
        <section>
            <form action="createFilter.php" method="POST">
                Filter Name: <input type="text" name="filter-name"/>
                <input type="submit" value="Create Filter"/>
            </form>
        </section>
        Select filter to edit: <select onChange="window.location='settings.php?filter='+this.value">
            <option></option>
            <option value="faults">Faults</option>
            <option value="test">Test</option>
        </select>
        <?php
                    
        if(isset($_GET['filter']))
        {
            $allTables = $conn->query('SHOW TABLES LIKE "%Filter"');
            
            $filters = [];

            while($row = mysqli_fetch_array($allTables))
            {
                $filters[] = $row['Tables_in_rag (%Filter)'];
            }
            
            if (in_array($_GET['filter'] . 'Filter', $filters))
            {
                
                $faultsFilter = $conn->query('SELECT * FROM '. $_GET['filter'] .'Filter');

                $pools = [];
                $amberKpi = [];
                $redKpi = [];
                
                while($row = mysqli_fetch_array($faultsFilter))
                {
                    $pools[] = $row['pool'];
                    $amberKpi[] = $row['amber_kpi'];
                    $redKpi[] = $row['red_kpi'];
                }
                ?>
                <form>
                <table width="100%">
                    <thead>
                        <tr>
                            <td class="main-table-header">Filter Settings</td>
                        </tr>
                        <tr>
                            <td>vISP</td>
                            <td>Pool</td>
                            <td>Subscribe</td>
                            <td>Amber KPI</td>
                            <td>Red KPI</td>
                        </tr>
                    </thead>
                    <tbody>
                <?php
                for($i = 0; $i < count($allPNPools); $i++) {
                ?>
                    <tr>
                        <td>PN</td>
                        <td><?php echo $allPNPools[$i]?></td>
                        <td><input type="checkbox" name="test"<?php if(in_array($allPNPools[$i], $pools)){ echo 'checked'; } ?>/></td>
                        <td><input type="input" name="test-amber-kpi" value="<?php if(in_array($allPNPools[$i], $pools)){ $pos = array_search($allPNPools[$i], $pools); echo $amberKpi[$pos];}else { echo '0';}?>"/></td>
                        <td><input type="input" name="test-red-kpi" value="<?php if(in_array($allPNPools[$i], $pools)){ $pos = array_search($allPNPools[$i], $pools); echo $redKpi[$pos]; }else { echo '0'; }?>"/></td>
                    </tr>
                    </tbody>

                <?php
                }
                ?>
                </table>
                    <input type="submit" value="Update"/>
                </form>
            <?php    
            }
            else
            {
                echo '</br>Filter does not exsist';
            }
        }
        ?>
    </body>
</html>
