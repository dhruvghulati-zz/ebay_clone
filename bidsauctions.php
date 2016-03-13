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
    <script src="js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <script src="clockCode/countdown.js"></script>

</head>

<body>

<!-- Navigation -->
<?php
include 'nav.php';
?>

<div class="container" style="padding-top:50px">
    <div class="row" style="padding-top:50px">
        <div class="col-sm-12 col-md-10 col-lg-12">
            <!--            Start of table-->
            <table class="table table-hover">
                <!--                    This is the headers of the table-->
                <thead>
                <tr>
                    <th>Product</th>
                    <th class="text-center">Bid Info</th>
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
                <!--                The body of the table-->
                <tbody>
                <?php
                $userid = $_SESSION['user_id'];
                //If bidder
                if ($_SESSION['role_id'] == 1) {
                    $sql = "SELECT a.auction_id,a.reserve_price, a.viewings, i.label,i.item_picture,max(b.bid_price) as bid_price,u.first_name,b.user_id,a.end_time,a.current_bid FROM Bids b
                            INNER JOIN Auction a ON a.auction_id = b.auction_id
                            INNER JOIN Users u ON u.user_id = a.user_id
                            INNER JOIN Item i ON a.item_id = i.item_id WHERE b.user_id = $userid
                            GROUP BY b.auction_id ORDER BY a.end_time DESC";
                }
                //               //If seller
                if ($_SESSION['role_id'] == 2) {
//                    No information on bids
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
                    <tr style="vertical-align">
                        <td class="col-sm-12 col-md-4">
                            <div class="media">
                                <a class="thumbnail pull-left" href="#"> <img class="media-object"
                                                                              src="<?php
                                                                              echo $bidauction['item_picture'];
                                                                              ?>"
                                                                              style="width: 72px; height: 72px;"> </a>
                                <div class="media-body">
                                    <h4 class="media-heading">
                                        <a href="productpage.php?auct=<?php echo $bidauction['auction_id']; ?>">
                                            <?php
                                            echo htmlspecialchars($bidauction['label']);
                                            ?></a></h4>
                                    <?php
                                    $auctionID = $bidauction['auction_id'];
                                    $previousSQL = 'SELECT u.user_id, u.username,b.bid_confirmed FROM
                                            Bids b, Users u WHERE b.user_id =u.user_id AND b.auction_id =:auctionID ORDER BY b.bid_price DESC LIMIT 1';
                                    $previousSTMT = $db->prepare($previousSQL);
                                    $previousSTMT->bindParam(':auctionID', $auctionID);
                                    $previousSTMT->execute();
                                    $result = $previousSTMT->fetch();
                                    ?>
                                    <!--                                    Time remaining in days and minutes-->
                                    <h5 id="timeRem" class="media-heading"> Time Remaining: <em>
                                            <!--                                            --><?php
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
                                            //
                                            //                                            ?>
                                        </em>
                                    </h5>
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
                                        if ($bidauction['bid_price'] >= $bidauction['current_bid'] && $enddt < time() && isset($_POST['winConfirm'])) {
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
                                <span>Final Status: </span><span class="text-success"><strong>
                                        <?php
                                        if ($enddt < time() && $result['bid_confirmed'] == 1) {
                                            echo 'Confirmed by ' . $result['username'];
                                        }
                                        if ($enddt < time() && $result['bid_confirmed'] == 0 && $bidauction['current_bid'] > $bidauction['reserve_price']) {
                                            echo 'Win unconfirmed';
                                        }
                                        if ($enddt < time() && ($bidauction['current_bid'] < $bidauction['reserve_price'])) {
                                            echo 'Didn\'t meet reserve';
                                        }
                                        ?>
                                    </strong></span><br>
                            </div>
                        </td>
                        <td class="col-sm-2 col-md-2"><strong></strong>
                            <h5 class="media-heading"> Number of Bids: <?php
                                $numsql = "SELECT count(b.bid_id) as bidcount FROM Bids b
                            WHERE auction_id=$auctionID GROUP BY auction_id ";
                                try {
                                    $numdata = $db->query($numsql);
                                    $numdata->setFetchMode(PDO::FETCH_ASSOC);
                                    $numbids = $numdata->fetch();
                                } catch (PDOException $e) {
                                    echo 'ERROR: ' . $e->getMessage();
                                }
                                echo htmlspecialchars($numbids['bidcount']);
                                ?></h5>
                            <h5 class="media-heading"> Highest Bidder: <a
                                    href="profile.php?user=<?php echo $result['user_id']; ?>"><?php
                                    echo htmlspecialchars($result['username'])
                                    ?></a></h5>
                            <h5 class="media-heading"> Viewings: <?php
                                echo htmlspecialchars($bidauction['viewings'])
                                ?></h5>
                        </td>
                        <td class="col-sm-2 col-md-2 text-center"><strong><?php
                                if ($_SESSION['role_id'] == 1) {
                                    echo htmlspecialchars($bidauction['bid_price']);

                                }
                                if ($_SESSION['role_id'] == 2) {
                                    echo htmlspecialchars($bidauction['reserve_price']);
                                }
                                ?></strong></td>
                        <td class="col-sm-2 col-md-2 text-center"><strong><?php

                                echo htmlspecialchars($bidauction['current_bid']);
                                ?>
                                <div>
                                    <span>Reserve: </span><span class="text-success"><strong>
                                            <?php
                                            echo $bidauction['reserve_price'];
                                            ?>
                                        </strong></span><br>
                                </div>


                            </strong>

                        </td>
                        <td class="col-sm-2 col-md-2">
                            <!--                            Raise bid logic-->
                            <?php
                            if ($_SESSION['role_id'] == 1 && $enddt > time()) {
                                $id = $bidauction['auction_id'];
                                echo '<a href="productpage.php?auct=' . $id . '" class="btn btn-success" style="margin-top:10px">
    <span class="glyphicon glyphicon-hand-up"></span> Raise Bid
    </a>';
                            }
                            if ($_SESSION['role_id'] == 2 && $enddt > time()) {
                                ?>
                                <form action="" method="POST">
                                    <button type="submit" id="stopauction" name="stopAuction"
                                            value="<?php echo $bidauction['auction_id'] ?>"
                                            class="btn btn-danger stopAuction">
                                        Stop Auction
                                    </button>
                                </form>
                                <?php
                            }
                            ?>
                            <?php
                            //                            Stop auction logic
                            if (isset($_POST['stopAuction']) and is_numeric($_POST['stopAuction'])) {
                                $now = new DateTime();
                                $time = $now->format("Y-m-d H:i:s");
                                $id = $_POST['stopAuction'];
//                                echo $time;
                                $updatesql = "UPDATE Auction
                                SET end_time=:nowtime
                                WHERE auction_id=:auctionID";
//                                echo $updatesql;
                                $stmt = $db->prepare($updatesql);
                                $stmt->bindParam(':nowtime', $time);
                                $stmt->bindParam(':auctionID', $id);
                                $stmt->execute();
                            }
                            ?>
                            <!--                            Confirm win logic-->
                            <?php
                            if ($_SESSION['role_id'] == 1 && $enddt < time() && $bidauction['bid_price'] >= $bidauction['current_bid']
                                && $bidauction['current_bid'] > $bidauction['reserve_price']
                            ) {
                                ?>
                                <form action="" method="post">
                                <input hidden name="auction_id" value="<?php echo $bidauction['auction_id']; ?>"/>
                                <button type="submit" id="confirmwin" name="winConfirm"
                                        class="btn btn-success showArchived">
                                <span class="glyphicon glyphicon-play"></span>
                                <?php
                                if ($result['bid_confirmed'] == 1){
                                    echo 'Win Confirmed';
                                }
                                else{
                                    echo 'Confirm Win';
                                }
                                ?>
                                    </button>
                                    </form>
                                    <?php
                            }
                            if (isset($_POST['winConfirm'])) {
                                $id = $_POST['auction_id'];
                                $updatesql = "UPDATE Bids
                                SET bid_confirmed=1
                                WHERE auction_id=:auctionID";
                                //                                echo $updatesql;
                                $stmt = $db->prepare($updatesql);
                                $stmt->bindParam(':auctionID', $id);
                                $stmt->execute();
                            }

                            ?>

                        </td>
                    </tr>

                <?php endwhile; ?>
                <tr>
                    <td>  </td>
                    <td>  </td>
                    <td>  </td>
                    <td></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    //This doesn't work because button disappears anyways
        $('#stopauction').on('click', function () {
            var $el = $(this),
                textNode = this.lastChild;
            $el.find('span').toggleClass('glyphicon-fire glyphicon-road');
            textNode.nodeValue = ($el.hasClass('stopAuction') ? 'Stop Auction' : 'Auction Stopped');
            $el.toggleClass('stopAuction');
        });

        setClock(<?php
        //        $time = new DateTime($bidauction['end_time']);
        //        echo '"' . $time->format("Y-m-d\TH:i:s") . '"';
        //        ?>//, 'bidsauctions.php', 'timeRem');
</script>
</body>
</html>