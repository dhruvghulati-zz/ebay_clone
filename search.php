<?php

//$by_lowest_time = $_POST['by_lowest_time'];
//    $by_highest_time = $_POST['by_highest_time'];
//    $by_lowest_price = $_POST['by_lowest_price'];
//    $by_highest_price = $_POST['by_highest_price'];
//    $by_oldest = $_POST['by_oldest'];
//    $by_newest = $_POST['by_newest'];
//    $by_seller = $_POST['by_seller'];

require_once 'dbConnection.php';

function search_auctions() {
    global $db;
    $by_name_description = $_POST['by_name_description'];

    $itemquery = ("SELECT * FROM ebay_clone.Auction a
                INNER JOIN ebay_clone.Item i ON i.item_id = a.item_id
                INNER JOIN ebay_clone.Users u ON u.user_id = a.user_id");

    $conditions = array();

    if($by_name_description !="") {
        $conditions[] = "(i.name='$by_name_description' OR i.features='$by_name_description')";
    }
//    if($by_lowest_time !="") {
//        $conditions[] = "sex='$by_sex'";
//    }
//    if($by_highest_time !="") {
//        $conditions[] = "blood_group='$by_group'";
//    }
//    if($by_lowest_price !="") {
//        $conditions[] = "e_level='$by_level'";
//    }
//    if($by_highest_price !="") {
//        $conditions[] = "e_level='$by_level'";
//    }
//    if($by_oldest !="") {
//        $conditions[] = "e_level='$by_level'";
//    }
//    if($by_newest !="") {
//        $conditions[] = "e_level='$by_level'";
//    }
//    if($by_newest !="") {
//        $conditions[] = "e_level='$by_level'";
//    }

    if (count($conditions) > 0) {
        $itemquery .= " WHERE " . implode(' AND ', $conditions);
    }

    http://stackoverflow.com/questions/26441003/building-dynamic-pdo-mysql-query
    $itemsql = $db->prepare($itemquery);
    $result = $db->query($itemsql, PDO::FETCH_ASSOC);
    return $result;
}
?>