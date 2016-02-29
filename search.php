<?php
/**
 * Created by PhpStorm.
 * User: dhruv
 * Date: 29/02/2016
 * Time: 18:53
 */

function search_auctions($_POST) {
    $by_name_description = $_POST['by_name_description'];
    $by_lowest_time = $_POST['by_lowest_time'];
    $by_highest_time = $_POST['by_highest_time'];
    $by_lowest_price = $_POST['by_lowest_price'];
    $by_highest_price = $_POST['by_highest_price'];
    $by_oldest = $_POST['by_oldest'];
    $by_newest = $_POST['by_newest'];
    $by_seller = $_POST['by_seller'];
    //Sort out the filtering by the long list of categories here.
    //https://www.sitepoint.com/community/t/using-php-drop-down-to-filter-mysql-table-data/8050/9

    //Do real escaping here

    $itemquery = "SELECT * FROM ebay_clone.Item i INNER JOIN ebay_clone.Auction a WHERE a.item_id=i.item_id";
    $sellerquery = "SELECT * FROM ebay_clone.Auction a INNER JOIN ebay_clone.Users u WHERE a.user_id=u.user_id";
    $conditions = array();

    if($by_name_description !="") {
        //This needs adjusting to allow for multiple conditions
        $conditions[] = "name='$by_name_description' OR features='$by_name_description'";
    }
    if($by_lowest_time !="") {
        $conditions[] = "sex='$by_sex'";
    }
    if($by_highest_time !="") {
        $conditions[] = "blood_group='$by_group'";
    }
    if($by_lowest_price !="") {
        $conditions[] = "e_level='$by_level'";
    }
    if($by_highest_price !="") {
        $conditions[] = "e_level='$by_level'";
    }
    if($by_oldest !="") {
        $conditions[] = "e_level='$by_level'";
    }
    if($by_newest !="") {
        $conditions[] = "e_level='$by_level'";
    }
    if($by_newest !="") {
        $conditions[] = "e_level='$by_level'";
    }

    $itemsql = $itemquery;
    $usersql = $sellerquery;
    if (count($conditions) > 0) {
        $itemsql .= " WHERE " . implode(' AND ', $conditions);
    }

    $result = mysql_query($itemsql);

    return $result;
}
?>