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
    $users = array();
    if ($result != FALSE) {
        // Get a list of all usernames and uids.
        while ($row = $result->fetchArray()) {
            $users[$row["id"]] = $row["username"];
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
        <!-- Nothing happening with those buttons. -->
        <div class="button button-green button-text">New Receipt</div> 
        <div class="button button-red button-text">Delete Receipt</div>
    </div>
    <div id='saldo'>
        <h3>Saldo</h3>
        <table>
            <thead>
                <th>Wer?</th><th>Wie viel?</th>
                <!-- Nothing happening here, tbd... -->
            </thead>
            <?php
            ?>
        </table>
    </div>
    <!-- List of purchases -->
    <div id='zahlungen'>
        <table class='scrollable'>
            <thead><th>Was?</th><th>Wer?</th><th>Wann?</th><th>Wie viel?</th></thead>
            <?php
            // Prepare the list of all purchases
                $query = "SELECT * FROM purchase";
                $result = $db->query($query);
                if (result != FALSE) {
                    // For every purchase found
                    while ($row = $result -> fetchArray()) {
                        // Write a row in this Database
                        echo "<tr><td>".$row["title"]."</td><td>".$users[$row["uid"]]."</td><td>".$row["buydate"]."</td><td>".$row["sum"]." €</td></tr>";
                    }
                }
            ?>
        </table>
    </div>
</body>
</html>
