<?php

require_once 'dbConnection.php';

if (isset($_POST['submit'])) {
    $currentBid=$_POST['current_bid'];
    $newBid=$_POST['new_bid'];
    $auctionID=$_POST['auction_id'];
    $bidTime=$_POST['bid_time'];
    $userID=$_POST['user_id'];

    if ($newBid > $currentBid) {
        $sql = 'UPDATE Auction SET current_bid=:newBid WHERE auction_id=:auctionID';
        $response = $db->prepare($sql);
        $response->bindParam(':newBid', $newBid);
        $response->bindParam(':auctionID', $auctionID);
        $response->execute();

        //Insert into the Bids table
        $bidsql = 'INSERT INTO Bids (user_id, auction_id, bid_price, bid_time)
        VALUES (:userID, :auctionID, :newBid, :bidTime)';
        $bidupdate = $db->prepare($bidsql);
        $bidupdate->bindParam(':userID', $userID);
        $bidupdate->bindParam(':auctionID', $auctionID);
        $bidupdate->bindParam(':newBid', $newBid);
        $bidupdate->bindParam(':bidTime', $bidTime);
        $bidupdate->execute();

        header('location: bidsauctions.php');
    }
}