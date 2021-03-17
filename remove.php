<?php
    include("data/access.php");
    $db = openDB('data/budgeteer.sqlite3');
    $query = "";
    $row = "";
    if (!isset($_GET["del"])) {
        $query = 'SELECT buydate, title, uid, sum, comment FROM purchase WHERE id='.$_GET['id'];
    } else {
        if ($_GET["del"] == 1) {
        $query = "DELETE FROM purchase WHERE id=".$_GET['id'];
        }
    }
    
    try {
        $results=$db->query($query);
    } catch (PDOException $e) { // Did it work?
        // No, print an errormessage
        echo "Error ".$e->getCode()."! Last Message was:<br/>".$e->getMessage()."<br/> Call was: ".$call;
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
    if (isset($_GET["del"])) {
        echo '<script type="text/javascript">location.href="./index.php";</script>';
    }
    ?>
</head>

<h1>Are you sure?</h1>
Are you sure you want to delete this entry?<br>
<?php
if (!isset($_GET["del"])) {
    $row = $results->fetch();
    echo "<b>Title: </b>".$row["title"]."<br><b>Buyer: </b>".$row["uid"]."<br><b>Sum: </b>".$row["sum"]."<br><b>Comment: </b>".$row["comment"];
    echo"<br><a href='./remove.php?del=1&id=".$_GET["id"]."'>Yes</a> <a href='./index.php'>No</a>";
}
?>
</body>
</html>
