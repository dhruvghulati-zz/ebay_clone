<?php
//global $dsn, $db_user,$db_pass, $db;
$dsn = 'mysql:host=localhost;dbname=ebay_clone';
$db_user = 'ebay_admin';
$db_pass = '192837465';

try{
    $db = new PDO($dsn, $db_user, $db_pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e){
    echo "Error: " . $e->getMessage();
}