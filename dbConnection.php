<?php
$DB_host = "localhost";
$DB_user = "ebay_admin";
$DB_pass = "192837465";
$DB_name = "ebay_clone";

try{
    $db = new PDO("mysql: host = {$DB_host}; dbname = {$DB_name}", $DB_user, $DB_pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e){
    echo "Error: " . $e->getMessage();
}