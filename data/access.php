<?php

/**
 * 
 */
function openDB($dbfile) {
    $db = new SQLite3($dbfile);
    return $db;
}

/**
 * 
 */
function createTables($db) {
    // Create a Table of users first
    $call = 'CREATE TABLE IF NOT EXISTS users (id INTEGER PRIMARY KEY AUTOINCREMENT, username VARCHAR, password VARCHAR)';
    $result = $db->query($call);
    // Everything went okay?
    if ($result == FALSE) { // No, give an error Message and leave the function
        echo "Error ".$db->lastErrorCode()."! Last Message was:<br/>".$db->lastErrorMsg()."<br/> Call was: ".$call;
        return 1;
    }
    
    
    // Create a List for current month
    $call = 'CREATE TABLE IF NOT EXISTS purchase (id INTEGER PRIMARY KEY AUTOINCREMENT, uid INTEGER NOT NULL, sum UNSIGNED INTEGER, comment VARCHAR, buydate DATE, entrydate DATE, lastmod DATE, FOREIGN KEY (uid) REFERENCES users(id))';
    $result = $db->query($call);
    if ($result == FALSE) { // No, give an error Message and leave the function
        echo "Error ".$db->lastErrorCode()."! Last Message was:<br/>".$db->lastErrorMsg()."<br/> Call was: ".$call;
        return 1;
    }
    return 0;
}


?>
