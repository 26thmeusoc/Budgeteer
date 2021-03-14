<?php
    include("data/access.php");
    $db =  openDB('data/budgeteer.sqlite3');
    echo "Got: ".$_POST["name"];
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
    <script>
        function changeFilter(newFilter) {
            var elements = document.getElementsByClassName("filter");
            var i;
            for (i=0; i<elements.length; i++) {
                elements[i].classList.remove("filtersel");
            }
            
            if (newFilter == 'm') {
                document.getElementById("filterM").classList.add("filtersel");
                document.getElementById("filterM").classList.remove("filterunsel");
                document.getElementById("filterY").classList.remove("filtersel");
                document.getElementById("filterY").classList.add("filterunsel");
                document.getElementById("yearselector").classList.add("hidden");
                document.getElementById("yearselector").classList.remove("visible");
                document.getElementById("monthselector").classList.add("visible");
                document.getElementById("monthselector").classList.remove("hidden");
            }
            if (newFilter == 'y') {
                document.getElementById("filterY").classList.add("filtersel");
                document.getElementById("filterY").classList.remove("filterunsel");
                document.getElementById("filterM").classList.remove("filtersel");
                document.getElementById("filterM").classList.add("filterunsel");
                document.getElementById("yearselector").classList.add("visible");
                document.getElementById("yearselector").classList.remove("hidden");
                document.getElementById("monthselector").classList.add("hidden");
                document.getElementById("monthselector").classList.remove("visible");
            }
        }
    </script>
    <title>Budgeteer</title>
</head>
<body>
    <div id="filterbox">
        <div id="filterselector">
            <div id="filterM" class="filter filtersel" onclick='changeFilter("m")'>
                by Month
            </div>
            <div id="filterY" class="filter filterunsel" onclick='changeFilter("y")'>
                by Year
            </div>
        </div>
        <div id="monthselector" class="visible">
            <form action="./filter.php?mode=month" method="post">
                <select id="name" name="name">
                    <?php
                        $query = 'SELECT DISTINCT strftime("%m-%Y",purchase.buydate) as monthyear FROM purchase ORDER BY purchase.buydate DESC';
                        try {
                            $results = $db->query($query);
                        } catch (PDOException $e) {
                            echo "Error ".$e->getCode()."! Last Message was:<br/>".$e->getMessage()."<br/> Call was: ".$call;
                        }
                        $result=$results->fetchAll();
                        
                        foreach ($result as $row) {
                            echo "<option value='".$row["monthyear"]."'>".$row["monthyear"]."</option>";
                        }
                    ?>
                </select>
                <input type="submit" value="Submit">
            </form>
        </div>
        <div id="yearselector" class="hidden">
            <form action="./filter.php?mode=year" method="post">
                <select id="name" name="name">
                    <?php
                        $query = 'SELECT DISTINCT strftime("%Y",purchase.buydate) as year FROM purchase ORDER BY purchase.buydate DESC';
                        try {
                            $results = $db->query($query);
                        } catch (PDOException $e) {
                            echo "Error ".$e->getCode()."! Last Message was:<br/>".$e->getMessage()."<br/> Call was: ".$call;
                        }
                        $result=$results->fetchAll();
                        
                        foreach ($result as $row) {
                            echo "<option value='".$row["year"]."'>".$row["year"]."</option>";
                        }
                    ?>
                </select>
                <input type="submit" value="Submit">
        </div>
    </div>
    <?php
        if (isset($_GET["mode"])) {
            echo "<div id='zahlungen' class='scrollable'><table><thead><tr><th>Was?</th><th>Wer?</th><th>Wann?</th><th>Wie viel?</th></tr></thead><tbody>";
            if ($_GET["mode"] == "month") {
                $query = 'SELECT purchase.title, users.username, sum as zahlung, purchase.buydate FROM purchase LEFT JOIN users ON users.id = purchase.uid WHERE strftime("%m-%Y",purchase.buydate) = "'.$_POST["name"].'" ORDER BY purchase.buydate DESC';
            } elseif ($_GET["mode"] == "year") {
                $query = 'SELECT purchase.title, users.username, sum as zahlung, purchase.buydate FROM purchase LEFT JOIN users ON users.id = purchase.uid WHERE strftime("%Y",purchase.buydate) = "'.$_POST["name"].'" ORDER BY purchase.buydate DESC';
            }
            
            try {
                $result = $db->query($query);
            } catch (PDOException $e) {
                echo "Error ".$e->getCode()."! Last Message was:<br/>".$e->getMessage()."<br/> Call was: ".$call;
            }
            $results = $result->fetchAll();
            // Prepare the list of all purchases
            // For every purchase found
            foreach($results as $row) {
                // Write a row in this Database
                echo "<tr><td>".htmlentities($row["title"],ENT_QUOTES,'UTF-8')."</td><td>".htmlentities($row["username"],ENT_QUOTES,'UTF-8')."</td><td>".date("d.m.y",strtotime($row["buydate"]))."</td><td class='zahlung'>".number_format((float)$row["zahlung"],2,',','.')." €</td></tr>";
            }
            echo "</tbody></table>";
        }
    ?>
</body>
