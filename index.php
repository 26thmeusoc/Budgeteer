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
    <script>
        function expand(id,background) {
            if (document.getElementById("commentbox".concat(id)) == null) {
                var xhttpr = new XMLHttpRequest();
                xhttpr.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("trow".concat(id)).insertAdjacentHTML("afterend",this.responseText);
                    }
                }
                xhttpr.open("GET", "expand.php?id=".concat(id), true);
                xhttpr.send();
            }
        }
    </script>
</head>
<body>
    <!-- Put this button at the buttom of the page so adding a new entry ist easier to reach -->
    <div class="clearfix">
    </div>
    <div id='saldo'>
        <h3>Saldo</h3>
        <div class="menubox">
        <table id="saldo">
            <thead>
                <th>Who?</th><th>How much?</th>
            </thead>
            <tbody>
            <?php
                // Get all payments in this focus. Sum them automatically and connect uid to username.
                // Default filter is "this month".
                $query = 'SELECT username, summe FROM users a LEFT JOIN (SELECT purchase.uid, SUM(purchase.sum) as summe FROM purchase WHERE strftime("%m%Y",purchase.buydate) = strftime("%m%Y",DATE("now")) GROUP BY purchase.uid) b ON a.id = b.uid ';
                try { // Try to execute this
                    $result = $db->query($query);
                } catch (PDOException $e) { // Did it work?
                    // No, print an errormessage
                    echo "Error ".$e->getCode()."! Last Message was:<br/>".$e->getMessage()."<br/> Call was: ".$call;
                }
                // Create an empty fullsum Value, so we can see, how much was payid
                $fullsum = (float)0.00;
                // Get all found rows
                $results = $result->fetchAll();
                foreach ($results as $row) { // For each row
                    // Add paid sum to fullsum
                    $fullsum = $fullsum+((float)$row["summe"]);
                    // Add a new row in the table for this user
                    echo "<tr><td>".htmlentities($row["username"],ENT_QUOTES,'UTF-8')."</td><td class='zahlung'>".number_format((float)$row["summe"],2,',','.')." € </td></tr>";
                }
                ?>
                <!-- All Users are shown, now show complete total -->
                <tr><td></td><td class="summe zahlung zahl" style="position:sticky"><?php
                echo number_format((float)$fullsum,2,',','.')
                ?> €</td></tr>
            </tbody>
        </table>
        <!-- Show a link to the filterpage -->
        <div style="display:flex;justify-content:flex-end;">
        <a href="filter.php" style="text-decoration:none"><div class="filterbutton">Filter</div></a>
        <a href="./add.php" style='height:100%;margin-left:5px;text-decoration:none;'><div class="button-add">New Receipt</div> </a>
        </div>
        </div>
    </div>
    <!-- List of purchases -->
    <div id='zahlungen' class='scrollable'>
        <!-- Display the detailed table -->
        <table>
            <!-- Add headers to the table -->
            <thead><tr><th>Description</th><th>Buyer</th><th>Date</th><th>Amount</th></tr></thead>
            <tbody>
            <?php
            // Select all required Information for this Table, default filter is: "this month", descending dates
            $query = 'SELECT purchase.id, purchase.title, users.username, sum as zahlung, purchase.buydate FROM purchase LEFT JOIN users ON users.id = purchase.uid WHERE strftime("%m%Y",purchase.buydate) = strftime("%m%Y",DATE("now")) ORDER BY purchase.buydate DESC';
            try { // Try to execute this
                $result = $db->query($query);
            } catch (PDOException $e) { // Did it work?
                // No, print an errormessage
                echo "Error ".$e->getCode()."! Last Message was:<br/>".$e->getMessage()."<br/> Call was: ".$call;
            }
            $results = $result->fetchAll();
            $counter = 0;
            // Prepare the list of all purchases
            // For every purchase found
            foreach($results as $row) {
                if ($counter%2 == 0) {
                    // Write a row in this Table
                    echo "<tr id='trow".$row["id"]."' onclick='expand(".$row["id"].",false);'><td>".htmlentities($row["title"],ENT_QUOTES,'UTF-8')."</td><td>".htmlentities($row["username"],ENT_QUOTES,'UTF-8')."</td><td>".date("d.m.y",strtotime($row["buydate"]))."</td><td class='zahlung'>".number_format((float)$row["zahlung"],2,',','.')." €</td></tr>";
                } else {
                    echo "<tr id='trow".$row["id"]."' onclick='expand(".$row["id"].",true);' class='alternateBackground'><td>".htmlentities($row["title"],ENT_QUOTES,'UTF-8')."</td><td>".htmlentities($row["username"],ENT_QUOTES,'UTF-8')."</td><td>".date("d.m.y",strtotime($row["buydate"]))."</td><td class='zahlung'>".number_format((float)$row["zahlung"],2,',','.')." €</td></tr>";
                }
                $counter++;
            }
            ?>
            </tbody>
        </table>
    </div>
</body>
</html>
