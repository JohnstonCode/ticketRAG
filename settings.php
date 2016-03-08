<?php
require_once('pools.php');
require_once('connect.php');

session_start();

$allTables = $conn->query('SHOW TABLES LIKE "%Filter"');

$filters = [];

while($allFilters = mysqli_fetch_array($allTables))
{
	$filters[] = $allFilters[0];
}
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
        <div id="settings-container">
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
          <a href="/" class="nav-link">Home</a><br />
          <fieldset>
              <legend>Upload</legend>
              <form action="upload.php" method="post" enctype="multipart/form-data" name="uploadReport">
                  Select NOC report: <input type="file" name="report">
                  <input type="submit" value="Upload" name="submit" class="buttons">
              </form>
          </fieldset>
          <fieldset>
              <legend>Filters</legend>
              <form action="createFilter.php" method="POST" name="createFilter">
                  Filter Name: <input type="text" name="filter-name"/>
                  <input type="submit" value="Create Filter" id="create-filter" class="buttons"/>
              </form>
              <form action="deleteFilter.php" method="POST" name="removeFilter">
                  Select filter to delete: <select id="removeFilterSelect" name="filter-to-remove">
                      <option></option>
                      <?php
                      for($i = 0; $i < count($filters); $i++)
                      {
                          echo '<option value="'. str_replace("Filter", "", $filters[$i]) .'">'. str_replace("Filter", "", $filters[$i]). '</option>';
                      }
                      ?>
                  </select>
                  <input type="submit" value="Remove Filter" class="buttons"/>
              </form>
          </fieldset>
          <fieldset>
              <legend>Edit filter:</legend>
          Select filter: <select onChange="window.location='settings.php?filter='+this.value">
              <option></option>
              <?php
              for($i = 0; $i < count($filters); $i++)
              {
                  echo '<option value="'. str_replace("Filter", "", $filters[$i]) .'">'. str_replace("Filter", "", $filters[$i]). '</option>';
              }
              ?>
          </select>
          </fieldset>
        <?php
                    
        if(isset($_GET['filter']))
        {
            
            if (in_array($_GET['filter'] . 'Filter', $filters))
            {
                
                $PNfaultsFilter = $conn->query('SELECT * FROM '. $_GET['filter'] .'Filter WHERE visp = "PN"');
                $JLPfaultsFilter = $conn->query('SELECT * FROM '. $_GET['filter'] .'Filter WHERE visp = "JLP"');
                $conn->close();

                $PNpools = [];
                $PNamberKpi = [];
                $PNredKpi = [];
                
                $JLPpools = [];
                $JLPamberKpi = [];
                $JLPredKpi = [];
                
                while($row = mysqli_fetch_array($PNfaultsFilter))
                {
                    $PNpools[] = $row['pool'];
                    $PNamberKpi[] = $row['amber_kpi'];
                    $PNredKpi[] = $row['red_kpi'];
                }
                
                while($row = mysqli_fetch_array($JLPfaultsFilter))
                {
                    $JLPpools[] = $row['pool'];
                    $JLPamberKpi[] = $row['amber_kpi'];
                    $JLPredKpi[] = $row['red_kpi'];
                }
                ?>
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
                        <td><input type="checkbox" name="visp-pn-<?php echo $allPNPools[$i]; ?>"<?php if(in_array($allPNPools[$i], $PNpools)){ echo 'checked'; } ?>/></td>
                        <td><input type="input" name="visp-pn-<?php echo $allPNPools[$i]; ?>-amber-kpi" value="<?php if(in_array($allPNPools[$i], $PNpools)){ $pos = array_search($allPNPools[$i], $PNpools); echo $PNamberKpi[$pos];}?>"/></td>
                        <td><input type="input" name="visp-pn-<?php echo $allPNPools[$i]; ?>-red-kpi" value="<?php if(in_array($allPNPools[$i], $PNpools)){ $pos = array_search($allPNPools[$i], $PNpools); echo $PNredKpi[$pos]; }?>"/></td>
                    </tr>
                    </tbody>
                    <?php
                    }
                    ?>
                    <tbody>
                    <?php
                    for($i = 0; $i < count($allJLPPools); $i++) {
                    ?>
                    <tr>
                        <td>JLP</td>
                        <td><?php echo $allJLPPools[$i]?></td>
                        <td><input type="checkbox" name="visp-jlp-<?php echo $allJLPPools[$i]; ?>"<?php if(in_array($allJLPPools[$i], $JLPpools)){ echo 'checked'; } ?>/></td>
                        <td><input type="input" name="visp-jlp-<?php echo $allJLPPools[$i]; ?>-amber-kpi" value="<?php if(in_array($allJLPPools[$i], $JLPpools)){ $pos = array_search($allJLPPools[$i], $JLPpools); echo $JLPamberKpi[$pos];}?>"/></td>
                        <td><input type="input" name="visp-jlp-<?php echo $allJLPPools[$i]; ?>-red-kpi" value="<?php if(in_array($allJLPPools[$i], $JLPpools)){ $pos = array_search($allJLPPools[$i], $JLPpools); echo $JLPredKpi[$pos]; }?>"/></td>
                    </tr>
                    </tbody>
                    <?php
                    }
                    ?>
                </table>
                <form action="editFilter.php" method="POST" name="filter">
                    <input type="hidden" name="<?php echo $_GET['filter']; ?>"/>
                    <input type="hidden" name="filters" id="test" value=""/>
                    <input type="button" value="Update" id="settings-button"/>
                </form>
            <?php    
            }
            else
            {
                echo '</br>Filter does not exsist';
            }
        }
        ?>
				</div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="scripts/main.js"></script>
    </body>
</html>
