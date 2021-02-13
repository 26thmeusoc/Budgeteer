<?php
    include("data/access.php");
    $db = openDB('data/budgeteer.sqlite3');
    $result = createTables($db);
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
        <div class="button button-green button-text">New Receipt</div>
        <div class="button button-red button-text">Delete Receipt</div>
    </div>
    <select name="month">
        <option value="jan-21">Jan 21</option>
        <option value="feb-21">Feb 21</option>
    </select>
    <div id='saldo'>
        <h3>Saldo</h3>
        <table>
            <thead>
                <th>Wer?</th><th>Wie viel?</th>
            </thead>
            <?php
            ?>
        </table>
    </div>
    <div id='zahlungen'>
        <table class='scrollable'>
            <thead><th>Was?</th><th></th><th>Wer?</th><th>Wie viel?</th><th></th></thead>
            <?php
            ?>
        </table>
    </div>
</body>
</html>
