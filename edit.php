<?php
// Access the database
include("data/access.php");
$db = openDB('data/budgeteer.sqlite3');

if (!isset($_GET["set"])) {
    $query = 'SELECT buydate, title, uid, sum, comment FROM purchase WHERE id='.$_GET['id'];
} else {
    $query = "UPDATE purchase SET buydate='".$_POST['pdate']."', title='".$_POST['title']."', uid=".$_POST['user'].", sum=".$_POST['cost'].", comment='".$_POST['comment']."' WHERE id=".$_GET["id"];
}

try {
    $result = $db->query($query);
} catch (PDOException $e) {
    echo "Error ".$e->getCode()."! Last Message was:<br/>".$e->getMessage()."<br/> Call was: ".$call;
}
if (!isset($_GET["set"])) {
    $row=$result->fetch();
}
?>
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
        if (isset($_GET["set"])) {
            echo '<script type="text/javascript">location.href="./index.php";</script>';
        }
    ?>
</head>
<body>
<h1>Edit receipt</h1>
<form action=<?php echo "./edit.php?set=1&id=".$_GET["id"]?> method="post" lang="de">
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
        foreach ($result as $urow) { // For each row
            // Add an option-Tag for this user. Use uid as value
            if ($urow["id"] == $row["uid"]) {
                echo "<option value='".$urow["id"]."' selected='selected'>".$urow["username"]."</option>";
            } else {
                echo "<option value='".$urow["id"]."'>".$urow["username"]."</option>";
            }
        }
        ?>
    </select>
    <!-- Ask the user for other Data needed -->
    <label for="pdate">Kaufdatum:</label>
    <input type="date" language="de-de" id="pdate" name="pdate" value=<?php echo '"'.$row["buydate"].'"';?>><br>
    <label for="title">Beschreibung:</label>
    <input type="text" name="title" id="title" value=<?php echo "'".$row["title"]."'";?>><br>
    <label for="cost">Kosten:</label>
    <!-- Create a Currency Inputfield -->
    <input type="number" step="0.01" id="cost" name="cost" value=<?php echo "'".$row["sum"]."'";?>><br>
    <label for="comment">Comment:</label>
    <input type="text" id="comment" name="comment" value=<?php echo "'".$row["comment"]."'"; ?>><br>
    <input type="submit" value="Submit">
</body>
</head>
