<?php
    include("data/access.php");
    $db = openDB('data/budgeteer.sqlite3');
    
    // Dirty hack ahead! Should not be done, cause this will add empty entries to our DB!
    if ($_GET["set"] == 1) {
        // Prepare the query
        $query = "INSERT INTO purchase (uid,sum,title,buydate) VALUES('".$_POST["user"]."','".$_POST["cost"]."','".$_POST["title"]."','".$_POST["pdate"]."')";
        $result = $db->query($query); // Execute it
        if ($result == FALSE) { // Was there an error?
            // Yes, show errormessage.
            echo "Could not add.<br>Error ".$db->lastErrorCode()."! Last Message was:<br/>".$db->lastErrorMsg()."<br/> Call was: ".$query;
        }
    }
    
    // Remove this.
    /*function getListOfUsers($db) {
        $query = "SELECT username FROM users";
        $result = $db->query($query);
        if ($result == FALSE) {
            echo "Error ".$db->lastErrorCode()."! Last Message was:<br/>".$db->lastErrorMsg()."<br/> Call was: ".$query;
            return 1;
        }
        return $result;
    }*/
?>

<!-- Display the standard Interface -->
<h1>Add a receipt</h1>
<form action="./add.php?set=1" method="post" lang="de">
    <label for="user">Buyer:</label>
    <select id="user" name="user">
        <?php
        // Create a list of all users
        $query = "SELECT * FROM users";
        $result = $db->query($query);
        // Everything worked?
        if ($result != FALSE) { // Yes, create a list of all users and use their name in this select Dialog
            while ($row = $result->fetchArray()) {
                echo "<option value='".$row["id"]."'>".$row["username"]."</option>";
            }
        }
        ?>
    </select>
    <!-- Ask the user for other Data needed -->
    <label for="pdate">Kaufdatum:</label>
    <input type="date" id="pdate" name="pdate"><br>
    <label for="title">Beschreibung:</label>
    <input type="text" name="title" id="title"><br>
    <label for="cost">Kosten:</label>
    <!-- Create a Currency Inputfield -->
    <input type="number" step="0.01" id="cost" name="cost">
    <input type="submit" value="Submit">
</form>
