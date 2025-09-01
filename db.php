<?php
// db.php
// Update credentials if needed. Using the DB values you provided.
$DB_HOST = 'localhost';
$DB_USER = 'uulevslgtrnau';
$DB_PASS = 'ld4dy42tkorz';
$DB_NAME = 'dblrteegbjqtom';
 
$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($mysqli->connect_errno) {
    die("DB Connect error: " . $mysqli->connect_error);
}
$mysqli->set_charset("utf8mb4");
session_start();
 
