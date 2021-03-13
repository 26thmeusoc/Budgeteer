<?php

/**
 * 
 */
function openDB($dbfile) {
    $db = new PDO("sqlite:".$dbfile);
    return $db;
}

/**
 * 
 */
function createTables($db) {
    // Create a Table of users first
    $call = 'CREATE TABLE IF NOT EXISTS users (id INTEGER PRIMARY KEY AUTOINCREMENT, username VARCHAR, password VARCHAR)';
    try {
        $result = $db->query($call);
        // Everything went okay?
    } catch (PDOException $e) { // No, give an error Message and leave the function
        echo "Error ".$e->getCode()."! Last Message was:<br/>".$e->getMessage()."<br/> Call was: ".$call;
        return 1;
    }
    
    
    // Create a List for current month
    $call = 'CREATE TABLE IF NOT EXISTS purchase (id INTEGER PRIMARY KEY AUTOINCREMENT, uid INTEGER NOT NULL, sum UNSIGNED INTEGER, title VARCHAR, comment VARCHAR, buydate DATE, entrydate DATE, lastmod DATE, FOREIGN KEY (uid) REFERENCES users(id))';
    try {
        $result = $db->query($call);
    } catch (PDOException $e) { // No, give an error Message and leave the function
        echo "Error ".$e->getCode()."! Last Message was:<br/>".$e->getMessage()."<br/> Call was: ".$call;
        return 1;
    }
    return 0;
}


?>
