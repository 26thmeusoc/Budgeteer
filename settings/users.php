<?php
    include("../data/access.php");
    $db = openDB('../data/budgeteer.sqlite3');
    
    $query = 'SELECT * FROM users';
    $result = $db->query($query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Budgeteer - Settings</title>
    <!-- What's in this file? -->
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
    <!-- Resposive Webdesign Info ahead! -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Load the stylesheet for this document! -->
    <link rel="stylesheet" type="text/css" href="../style/style.css" />
    </head>
<body>
<div>
<table>
    <thead>
        <tr><th>ID#</th><th>Username</th></tr>
    </thead>
<?php
    if (result != FALSE) {
        while ($row -> $result->fetch_array()) {
            echo '<tr class="userset-row"><td class="userset userset-id">'.$row['id'].'</td><td class="userset userset-name>'.$row['username'].'</td></tr>';
        }
    }
    else {
        echo 'Could not load Userdata. Error '.$result->lastErrorCode().'<br>Message was: '.$result->lastErrorMsg();
    }
?>
</table>
</div>
<div>
</div>
</body>
</html>
