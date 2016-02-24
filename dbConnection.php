<?php
$DB_host = "localhost";
$DB_user = "websiteManager";
$DB_pass = "websitePassword";
$DB_name = "ebay_clone";

try{
    $db = new PDO("mysql:host = {$DB_host}; dbname = {$DB_name}", $DB_user, $DB_pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e){
    echo $e->getMessage();
}