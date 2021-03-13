<?php
    include("data/access.php");
    $db = new PDO("sqlite:".'data/budgeteer.sqlite3');
    
    // Dirty hack ahead! Should not be done, cause this will add empty entries to our DB!
    if ($_GET["set"] == 1 && isset($_POST["name"])) {
        // Prepare the query
        $query = "INSERT INTO users (username) VALUES ('".htmlentities($_POST["name"],ENT_QUOTES,'UTF-8')."')";
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
