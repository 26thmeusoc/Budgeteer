<?php
    // Access the database
    include("data/access.php");
    $db = openDB('data/budgeteer.sqlite3');
    // Just in case, the database is empty, create the needed tables.
    $result = createTables($db);
?>
<!--
    Copyright (C) 2021  Dirk Braun  This program is free 
    software; you can redistribute it and/or modify it under the terms 
    of the GNU General Public License as published by the Free Software 
    Foundation; either version 2 of the License, or (at your option) 
    any later version.  This program is distributed in the hope that it 
    will be useful, but WITHOUT ANY WARRANTY; without even the implied 
    warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
    See the GNU General Public License for more details.  You should 
    have received a copy of the GNU General Public License along with 
    this program; if not, write to the Free Software Foundation, Inc., 
    51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
-->

<!DOCTYPE HTML>
<html>
<head>
    <!-- What's in this file? -->
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
    <!-- Resposive Webdesign Info ahead! -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Load the stylesheet for this document! -->
    <link rel="stylesheet" type="text/css" href="style/style.css" />
    <title>Budgeteer</title>
</head>
<body>
    <div class="clearfix">
        <a href="./add.php"><div class="button button-add button-text">New Receipt</div> </a>
    </div>
    <div id='saldo'>
        <h3>Saldo</h3>
        <div class="menubox">
        <table id="saldo">
            <thead>
                <th>Wer?</th><th>Wie viel?</th>
            </thead>
            <tbody>
            <?php
                // Get all payments in this focus
                $query = 'SELECT username, summe FROM users a LEFT JOIN (SELECT purchase.uid, SUM(purchase.sum) as summe FROM purchase WHERE strftime("%m%Y",purchase.buydate) = strftime("%m%Y",DATE("now")) GROUP BY purchase.uid) b ON a.id = b.uid ';
                try {
                    $result = $db->query($query);
                } catch (PDOException $e) {
                    echo "Error ".$e->getCode()."! Last Message was:<br/>".$e->getMessage()."<br/> Call was: ".$call;
                }
                $fullsum = (float)0.00;
                $results = $result->fetchAll();
                foreach ($results as $row) {
                    $fullsum = $fullsum+((float)$row["summe"]);
                    echo "<tr><td>".htmlentities($row["username"],ENT_QUOTES,'UTF-8')."</td><td class='zahlung'>".number_format((float)$row["summe"],2,',','.')." € </td></tr>";
                }
                ?>
                <tr><td></td><td class="summe zahlung zahl" style="position:sticky"><?php
                echo number_format((float)$fullsum,2,',','.')
                ?> €</td></tr>
            </tbody>
        </table>
        <a href="filter.php"><div class="filterbutton">Filter</div></a>
        </div>
    </div>
    <!-- List of purchases -->
    <div id='zahlungen' class='scrollable'>
        <table>
            <thead><tr><th>Was?</th><th>Wer?</th><th>Wann?</th><th>Wie viel?</th></tr></thead>
            <tbody>
            <?php
            $query = 'SELECT purchase.title, users.username, sum as zahlung, purchase.buydate FROM purchase LEFT JOIN users ON users.id = purchase.uid WHERE strftime("%m%Y",purchase.buydate) = strftime("%m%Y",DATE("now")) ORDER BY purchase.buydate DESC';
                try {
                    $result = $db->query($query);
                } catch (PDOException $e) {
                    echo "Error ".$e->getCode()."! Last Message was:<br/>".$e->getMessage()."<br/> Call was: ".$call;
                }
            $results = $result->fetchAll();
            // Prepare the list of all purchases
            // For every purchase found
            foreach($results as $row) {
                // Write a row in this Database
                echo "<tr><td>".htmlentities($row["title"],ENT_QUOTES,'UTF-8')."</td><td>".htmlentities($row["username"],ENT_QUOTES,'UTF-8')."</td><td>".date("d.m.y",strtotime($row["buydate"]))."</td><td class='zahlung'>".number_format((float)$row["zahlung"],2,',','.')." €</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
</body>
</html>
