<?php
    include("data/access.php");
    $db = openDB('data/budgeteer.sqlite3');
    
    $query = "SELECT comment FROM purchase WHERE id=".$_GET["id"]; 
    try {
        $result = $db->query($query); // Execute it
    } catch (PDOException $e) {
        echo "Error ".$e->getCode()."! Last Message was:<br/>".$e->getMessage()."<br/> Call was: ".$query;
    }
    $row = $result->fetch();
    echo "<tr id='commentbox".$_GET["id"]."' class='commentbox'><td colspan=3 class='commenttext'>";
    echo $row['comment'];
    echo "</td><td style='display:flex;'><a href='./edit.php?id=".$_GET["id"]."'><div class='editbutton'>Edit</div><a href='./remove.php?id=".$_GET["id"]."'><div class='removebutton'>Remove</div></div></a></td></tr>";
?>
