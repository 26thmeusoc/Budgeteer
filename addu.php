<?php
    include("data/access.php");
    $db = openDB('data/budgeteer.sqlite3');
    
    // Dirty hack ahead! Should not be done, cause this will add empty entries to our DB!
    if ($_GET["set"] == 1) {
        // Prepare the query
        $query = "INSERT INTO users (username) VALUES ('".$_POST["name"]."')";
        $result = $db->query($query);
        
        // Was there an error?
        if ($result == FALSE) { // Yes, so show an errormessage!
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
