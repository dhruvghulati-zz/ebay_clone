<?php

include_once 'dbConnection.php';
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Shop Homepage - Start Bootstrap Template</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>

</head>

<body>

<!-- Navigation -->
<?php
include 'nav.php';
?>

<div class="container" style="padding-top:50px">
    <div class="row" style="padding-top:50px">
        <div class="col-sm-12 col-md-10 col-md-offset-1">
            <!--            Start of table-->
            <table class="table table-hover">
                <!--                    This is the headers of the table-->
                <thead>
                <tr>
                    <th>Product</th>
                    <?php
                    if ($_SESSION['role_id'] == 2) {
                        echo '<th class="text-center">Your Reserve Price</th>';
                    } else if ($_SESSION['role_id'] == 1) {
                        echo '<th class="text-center">Your Last Bid</th>';
                    }
                    ?>
                    <th class="text-center">Current Price</th>
                    <th> Action</th>
                </tr>
                </thead>
                <tbody>
                <!--                Body of table-->
                <!--    Should echo a tr for each auction-->
                <?php
                //If seller
                $userid = $_SESSION['user_id'];
                //                    Only show the latest bid you have made for a product. Currently we show your max bid as the one when in fact
                //it should be latest bid
                if ($_SESSION['role_id'] == 1) {
                    $sql = "SELECT a.auction_id, viewings, label,item_picture,max(bid_price) as bid_price,u.first_name,b.user_id,a.end_time,a.current_bid FROM Bids b INNER JOIN Auction a ON a.auction_id = b.auction_id
                            INNER JOIN Users u ON u.user_id = a.user_id
                            INNER JOIN Item i ON a.item_id = i.item_id WHERE b.user_id = $userid
                            GROUP BY b.auction_id ORDER BY a.end_time DESC";
                }
                if ($_SESSION['role_id'] == 2) {
                    $sql = "SELECT * FROM Auction a
                            INNER JOIN Users u ON a.user_id = u.user_id
                            INNER JOIN Item i ON a.item_id = i.item_id WHERE a.user_id = $userid
                            ORDER BY a.end_time DESC";
                }
                try {
                    $data = $db->query($sql);
                    $data->setFetchMode(PDO::FETCH_ASSOC);
                } catch (PDOException $e) {
                    echo 'ERROR: ' . $e->getMessage();
                }
                ?>
                <?php while (($bidauction = $data->fetch())): ?>
                    <!--                    Returns an array-->
                    <!--                    If multiple bids for same item, should have the latest bid not just the max bid-->
                    <tr style="vertical-align">
                        <td class="col-sm-8 col-md-6">
                            <div class="media">
                                <a class="thumbnail pull-left" href="#"> <img class="media-object"
                                                                              src="<?php
                                                                              echo $bidauction['item_picture'];
                                                                              ?>"
                                                                              style="width: 72px; height: 72px;"> </a>
                                <div class="media-body">
                                    <!--                                    Should take you to the view auction-->
                                    <h4 class="media-heading">
                                        <a href="productpage.php?auct=<?php echo $bidauction['auction_id']; ?>">
                                            <?php
                                            echo htmlspecialchars($bidauction['label']);
                                            ?></a></h4>
                                    <!--                                    Should take you to seller profile-->
                                    <?php

                                    $auctionID = $bidauction['auction_id'];

                                    //Get previous bidder id
                                    $previousSQL = 'SELECT u.user_id, u.username FROM
                                            Bids b, Users u WHERE b.user_id =u.user_id AND b.auction_id =:auctionID ORDER BY b.bid_price DESC LIMIT 1';
                                    $previousSTMT = $db->prepare($previousSQL);
                                    $previousSTMT->bindParam(':auctionID', $auctionID);
                                    $previousSTMT->execute();
                                    $result = $previousSTMT->fetch();
                                    ?>
                                    <h5 class="media-heading"> Highest Bidder <a
                                            href="profile.php?user=<?php echo $result['user_id']; ?>"><?php
                                            echo htmlspecialchars($result['username'])
                                            ?></a></h5>
                                    <h5 class="media-heading"> Viewings <?php
                                        echo htmlspecialchars($bidauction['viewings'])
                                        ?></h5>
                                    <!--                                    Time remaining in days and minutes-->
                                    <h5 class="media-heading"> Time Remaining: <em>
                                            <?php
                                            $enddt = strtotime($bidauction['end_time']);
                                            $daysremaining = date("z", $enddt) - date("z");
                                            $hoursremaining = date("G", $enddt) - date("G");
                                            $minutesremaining = date("i", $enddt) - date("i");
                                            $secondsremaining = date("s", $enddt) - date("s");
                                            //                                            Put checks for if time remaining is negative
                                            if ($enddt > time()) {
                                                if ($daysremaining > 1) {
                                                    echo htmlspecialchars($daysremaining) . ' days' . ' ';
                                                } else {
                                                    if ($hoursremaining > 1) {
                                                        if ($hoursremaining > 0) {
                                                            echo htmlspecialchars($hoursremaining) . ' hours' . ' ';
                                                        }
                                                    } else {
                                                        if ($minutesremaining > 0) {
                                                            echo htmlspecialchars($minutesremaining) . ' minutes' . ' ';
                                                        }
                                                        if ($secondsremaining > 0) {
                                                            echo htmlspecialchars($secondsremaining) . ' seconds';
                                                        }
                                                    }
                                                }

                                            }
                                            if ($enddt <= time()) {
                                                echo 'Sorry, time is up!';
                                            }

                                            ?>
                                        </em></h5>
                                    <!--                                    If your bid is more than current bid, bid isnt finished etc-->
                                    <span>Time Status: </span><span class="text-success"><strong>
                                            <?php
                                            if ($enddt > time()) {
                                                echo 'Ongoing';
                                            }
                                            if ($enddt < time()) {
                                                echo 'Finished';
                                            }
                                            ?>
                                        </strong></span><br>
                                    <?php
                                    if ($_SESSION['role_id'] == 1) {
                                        echo '<span>Win Status: </span><span class="text-success"><strong>';

                                        if ($bidauction['bid_price'] >= $bidauction['current_bid'] && $enddt > time()) {
                                            echo 'Highest Bidder';
                                        }
                                        if ($bidauction['bid_price'] >= $bidauction['current_bid'] && $enddt < time()) {
                                            echo 'Item Won';
                                        }
                                        if ($bidauction['bid_price'] < $bidauction['current_bid'] && $enddt > time()) {
                                            echo 'Losing Item';
                                        }
                                        if ($bidauction['bid_price'] < $bidauction['current_bid'] && $enddt < time()) {
                                            echo 'Item Lost';
                                        }

                                        echo '</strong></span>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </td>
                        <td class="col-sm-1 col-md-1 text-center"><strong><?php
                                if ($_SESSION['role_id'] == 1) {
                                    echo htmlspecialchars($bidauction['bid_price']);
                                }
                                if ($_SESSION['role_id'] == 2) {
                                    echo htmlspecialchars($bidauction['reserve_price']);
                                }
                                ?></strong></td>
                        <td class="col-sm-1 col-md-1 text-center"><strong><?php
                                echo htmlspecialchars($bidauction['current_bid'])
                                ?></strong></td>
                        <td class="col-sm-1 col-md-1">
                            <?php
                            if ($_SESSION['role_id'] == 1 && $enddt > time()) {
                                $id = $bidauction['auction_id'];
                                echo '<a href="productpage.php?auct=' . $id . '" class="btn btn-success" style="margin-top:10px">
    <span class="glyphicon glyphicon-hand-up"></span> Raise Bid
    </a>';
                            }
                            if ($_SESSION['role_id'] == 2 && $enddt > time())
                            {
                                ?>
                                <form action="" method="POST"><button type="submit" name="stopAuction" value="<?php $bidauction['auction_id'] ?>" class="btn btn-danger">
                                <span class="glyphicon glyphicon-remove"></span> Stop Auction
                            </button></form>
                            <?php
                            }
                            ?>
                            <?php
                            //Cant get this to work.
                            if (isset($_POST['stopAuction']) and is_numeric($_POST['stopAuction'])) {
                                $now = new DateTime();
                                $time = $now->format("Y-m-d H:i:s");
                                echo $time;
                                $updatesql = "UPDATE Auction
                                SET end_time=:nowtime
                                WHERE auction_id=:auctionID";
//                                echo $updatesql;
                                $stmt = $db->prepare($updatesql);
                                $stmt->bindParam(':auctionID', $_POST['stopAuction']);
                                $stmt->bindParam(':nowtime', $time);
                                echo $stmt;
                                $stmt->execute();
                            }
                            ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
                <tr>
                    <td>  </td>
                    <td class="col-md-1 text-center"><h3>Potential Total</h3></td>
                    <td class="col-md-1 text-center"><h3><strong>
                                <?php while (($bidauction = $data->fetch())): ?>
                                    <?php
//                                    Can't seem to ge this working'
                                    $potentialowed = 0.00;
                                    foreach ($bidauction['current_bid'] as $bid) {
                                        if ($enddt > time()) {
                                            $potentialowed += $bid;
                                        }
                                    }
                                    echo htmlspecialchars($potentialowed);
                                    ?>
                                <?php endwhile; ?>
                            </strong></h3></td>
                    <td>
                        <a href="listings.php">
                            <button type="button" href="listings.php" class="btn btn-default">
                                <span class="glyphicon glyphicon-shopping-cart"></span>Back to Live Auctions
                            </button>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>  </td>
                    <td class="col-md-1 text-center"><h4>Current Owed</h4></td>
                    <td class="col-md-1 text-center"><h4><strong>
                                <?php
                                $data2 = $db->query($sql);
                                ?>

                                <?php
                                //                                Check if bidder the seller fucks it up
                                //                                    Can't seem to ge thsi working'
                                //                                Not saying I owe stuff even thought im highest bidder
                                $totalowed = 0.00;
                                foreach ($data2 as $bid) {
                                    if (($bid['bid_price'] >= $bid['current_bid']) && ($enddt < time())) {
                                        $totalowed += $bid['bid_price'];
                                    }
                                }
                                echo htmlspecialchars($totalowed);
                                ?>

                            </strong></h4></td>
                    <td>
                        <!--                        sellers shouldnt be able to checkout-->
                        <button type="button" class="btn btn-success">
                            Checkout <span class="glyphicon glyphicon-play"></span>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>