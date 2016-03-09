<?php

require_once 'dbConnection.php';

if (isset($_POST['submit'])) {
    $currentBid=$_POST['current_bid'];
    $newBid=$_POST['new_bid'];
    $auctionID=$_POST['auction_id'];
    if ($newBid > $currentBid) {
        $sql = 'UPDATE Auction SET current_bid=:newBid WHERE auction_id=:auctionID';
        $response = $db->prepare($sql);
        $response->bindParam(':newBid', $newBid);
        $response->bindParam(':auctionID', $auctionID);
        $response->execute();
        header('location: bidsauctions.php');
    }
}