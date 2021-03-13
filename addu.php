<?php
    include("data/access.php");
    $db = new PDO("sqlite:".'data/budgeteer.sqlite3');
    
    // Dirty hack ahead! Should not be done, cause this will add empty entries to our DB!
    if ($_GET["set"] == 1) {
        // Prepare the query
        $query = "INSERT INTO users (username) VALUES ('".$_POST["name"]."')";
        try {
            $result = $db->exec($query);
        } catch (PDOException $e) {
            echo "Error ".$e->getCode()."! Last Message was:<br/>".$e->getMessage()."<br/> Call was: ".$call;
        }
    }
    ?>

<h1>Add a User</h1>
<form action="./addu.php?set=1" method="post">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name"><br />
    <input type="submit" value="Submit">
</form>
