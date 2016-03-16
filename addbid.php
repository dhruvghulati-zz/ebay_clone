<?php

require_once 'dbConnection.php';

if (isset($_POST['submit'])) {

    $currentBid = $_POST['current_bid'];
    $newBid = $_POST['new_bid'];
    $auctionID = $_POST['auction_id'];
    $userID = $_POST['user_id'];
    $label = $_POST['item_label'];

    if ($newBid > $currentBid) {
        $time = new DateTime();
        $formatTime = $time->format("Y-m-d H:i:s");

        //Insert into the Bids table
        $bidsql = 'INSERT INTO Bids (user_id, auction_id, bid_price, bid_time)
        VALUES (:userID, :auctionID, :newBid, :bidTime)';
        $bidupdate = $db->prepare($bidsql);
        $bidupdate->bindParam(':userID', $userID);
        $bidupdate->bindParam(':auctionID', $auctionID);
        $bidupdate->bindParam(':newBid', $newBid);
        $bidupdate->bindParam(':bidTime', $formatTime);
        $bidupdate->execute();

        //Update Auction price
        $sql = 'UPDATE Auction SET current_bid=:newBid WHERE auction_id=:auctionID';
        $response = $db->prepare($sql);
        $response->bindParam(':newBid', $newBid);
        $response->bindParam(':auctionID', $auctionID);
        $response->execute();

        //Get previous bidder id
        $previousSQL = 'SELECT user_id, bid_price FROM ebay_clone.Bids WHERE auction_id = :auctionID ORDER BY bid_price DESC LIMIT 1, 1';
        $previousSTMT = $db->prepare($previousSQL);
        $previousSTMT->bindParam(':auctionID', $auctionID);
        $previousSTMT->execute();

        if ($previousUser = $previousSTMT->fetch()) {

            //Determine if previous bidder is watching this bid
            $watchSQL = 'SELECT * FROM Watch WHERE user_id = :previousUser AND auction_id = :auctionID';
            $watchSTMT = $db->prepare($watchSQL);
            $watchSTMT->bindParam(':previousUser', $previousUser['user_id']);
            $watchSTMT->bindParam(':auctionID', $auctionID);
            $watchSTMT->execute();

            if ($watchSTMT->fetch()) {

                include_once 'mailer.php';

                //Get the data of the previous user
                $userSQL = 'SELECT * FROM Users WHERE user_id = :previousUser';
                $userSTMT = $db->prepare($userSQL);
                $userSTMT->bindParam(':previousUser', $previousUser['user_id']);
                $userSTMT->execute();
                $user = $userSTMT->fetch();

                //Set who the message is to be sent to
                $mail->addAddress($user['email'], $user['first_name'] . ' ' . $user['last_name']);

                //Set the subject line
                $mail->Subject = 'You have been outbid on an auction!';

                //Replace the plain text body with one created manually
                $mail->Body = 'You just got outbid on the ' . $label . ' auction you were watching! The new bid is: ' . $currentBid;

                //send the message, check for errors
                if (!$mail->send()) {
                    echo "Mailer Error: " . $mail->ErrorInfo;
                } else {
                    echo "Message sent!";
                }
            }

        }
        header('Location: bidsauctions.php');
    } else if($newBid <= $currentBid) {
        $message="New bid needs to be higher than the current bid";
    }
}