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
                Time: <select name="time">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                    <option value="14">14</option>
                    <option value="15">15</option>
                    <option value="16">16</option>
                    <option value="17">17</option>
                    <option value="18">18</option>
                    <option value="19">19</option>
                    <option value="20">20</option>
                    <option value="21">21</option>
                    <option value="22">22</option>
                    <option value="23">23</option>
                    <option value="24">24</option>
                </select>
                <input type="submit" value="Upload" name="submit">
            </form>
        </section>
        <section>
            <form action="createFilter.php" method="POST">
                Filter Name: <input type="text" name="filter-name"/>
                <input type="submit" value="Create Filter"/>
            </form>
        </section>
        <form>
            <table width="100%">
                <thead>
                    <tr>
                        <td class="main-table-header">Filter Settings</td>
                    </tr>
                    <tr>
                        <td>Pool</td>
                        <td>Subscribe</td>
                        <td>Amber KPI</td>
                        <td>Red KPI</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Test</td>
                        <td><input type="checkbox" name="test"/></td>
                        <td><input type="value" name="test-amber-kpi"/></td>
                        <td><input type="value" name="test-red-kpi"/></td>
                    </tr>
                </tbody>
            </table>
            <input type="submit" value="Update"/>
        </form>
    </body>
</html>
