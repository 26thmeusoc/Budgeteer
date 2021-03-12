<?php
    // Access the database
    include("data/access.php");
    $db = openDB('data/budgeteer.sqlite3');
    // Just in case, the database is empty, create the needed tables.
    $result = createTables($db);
    
    /***
     * Get a list of all Users in this Database.
     ***/
    // Prepare the query.
    $query = "SELECT * FROM users";
    $result = $db->query($query);
    // Create arrays
    $users = array();
    $sums = array();
    $uids = array();
    if ($result != FALSE) {
        // Get a list of all usernames and uids.
        while ($row = $result->fetchArray()) {
            // Create an array, so we can easily map uid->username
            $users[$row["id"]] = $row["username"];
            // Create an array of uids
            array_push($uids,$row["id"]);
            // Create an array of sums they paid in this focus.
            $sums[$row["id"]] = 0;
        }
    } else {
        // Something went wrong
        echo "Could not load Userlist";
    }
?>
<!--
    Copyright (C) 2022  Dirk Braun  This program is free 
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
        <table id="saldo">
            <thead>
                <th>Wer?</th><th>Wie viel?</th>
            </thead>
            <tbody>
            <?php
                // Get all payments in this focus
                $query = "SELECT * FROM purchase";
                $purchases = $db->query($query);
                $fullsum = (float)0.00;
                if ($purchases != FALSE) {
                    // Sum, what everyone has paids
                    while ($row = $purchases->fetchArray()) {
                        $sums[$row["uid"]] = $sums[$row["uid"]]+$row["sum"];
                        $fullsum = $fullsum+((float)$row["sum"]);
                    }
                }
                
                // Print the results, do it for every uid found
                for ($i = 0;$i<count($uids);$i++) {
                    echo "<tr><td>".$users[$uids[$i]]."</td><td class='zahlung'>".number_format((float)$sums[$uids[$i]],2,',','.')." € </td></tr>";
                }
                ?>
                <tr><td></td><td class="summe zahlung zahl"><?php
                echo number_format((float)$fullsum,2,',','.')
                ?> €</td></tr>
            </tbody>
        </table>
    </div>
    <!-- List of purchases -->
    <div id='zahlungen' class='scrollable'>
        <table>
            <thead><tr><th>Was?</th><th>Wer?</th><th>Wann?</th><th>Wie viel?</th></tr></thead>
            <tbody>
            <?php
            // Prepare the list of all purchases
                if ($purchases != FALSE) {
                    $purchases->reset();
                    // For every purchase found
                    while ($row = $purchases -> fetchArray()) {
                        // Write a row in this Database
                        echo "<tr><td>".$row["title"]."</td><td>".$users[$row["uid"]]."</td><td>".$row["buydate"]."</td><td class='zahlung'>".number_format((float)$row["sum"],2,',','.')." €</td></tr>";
                    }
                }
            ?>
            </tbody>
        </table>
    </div>
</body>
</html>
