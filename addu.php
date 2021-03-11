<?php
    include("data/access.php");
    $db = openDB('data/budgeteer.sqlite3');
    
    if ($_GET["set"] == 1) {
        $query = "INSERT INTO users (username) VALUES ('".$_POST["name"]."')";
        $result = $db->query($query);
        
        if ($result == FALSE) {
            echo "Could not add.<br>Error ".$db->lastErrorCode()."! Last Message was:<br/>".$db->lastErrorMsg()."<br/> Call was: ".$query;
        }
    }
    ?>

<h1>Add a User</h1>
<form action="./addu.php?set=1" method="post">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name"><br />
    <input type="submit" value="Submit">
</form>
