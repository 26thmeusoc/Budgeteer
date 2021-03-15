<?php
    include("data/access.php");
    $db = openDB('data/budgeteer.sqlite3');
    
    // Dirty hack ahead! Should not be done, cause this will add empty entries to our DB!
    if ($_GET["set"] == 1 && isset($_POST["title"]) && $_POST['title']!="") {
        // Prepare the query
        $query = "INSERT INTO purchase (uid,sum,title,buydate) VALUES('".$_POST["user"]."','".$_POST["cost"]."','".htmlentities($_POST["title"],ENT_QUOTES,'UTF-8')."','".$_POST["pdate"]."')";
        try {
            $result = $db->exec($query); // Execute it
        } catch (PDOException $e) { // Did it work?
            // No, print an error Message
            echo "Error ".$e->getCode()."! Last Message was:<br/>".$e->getMessage()."<br/> Call was: ".$call;
        }
    }
?>

<!-- Display the standard Interface -->
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
    <?php
        if ($_POST["return"] == true) {
            echo '<script type="text/javascript">location.href="./index.php";</script>';
        }
    ?>
</head>
<body>
<h1>Add a receipt</h1>
<form action="./add.php?set=1" method="post" lang="de">
    <label for="user">Buyer:</label>
    <select id="user" name="user">
        <?php
        // Create a list of all users
        $query = "SELECT * FROM users";
        try { // Try to execute this
            $results = $db->query($query);
        } catch (PDOException $e) { // Did it work?
            // No, print an errormessage
            echo "Error ".$e->getCode()."! Last Message was:<br/>".$e->getMessage()."<br/> Call was: ".$call;
        }
        // Select all results
        $result = $results->fetchAll();
        foreach ($result as $row) { // For each row
            // Add an option-Tag for this user. Use uid as value
            echo "<option value='".$row["id"]."'>".$row["username"]."</option>";
        }
        ?>
    </select>
    <!-- Ask the user for other Data needed -->
    <label for="pdate">Kaufdatum:</label>
    <input type="date" language="de-de" id="pdate" name="pdate" value=<?php echo '"'.date("Y-m-d").'"';?>><br>
    <label for="title">Beschreibung:</label>
    <input type="text" name="title" id="title"><br>
    <label for="cost">Kosten:</label>
    <!-- Create a Currency Inputfield -->
    <input type="number" step="0.01" id="cost" name="cost"><br>
    <label for="return">Return to overview after adding:</label>
    <input type="checkbox" id="return" name="return">Return afterwards</input><br>
    <input type="submit" value="Submit">
</form>
</body>
</html>
