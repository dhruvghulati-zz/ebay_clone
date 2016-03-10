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

    <!-- Custom CSS -->
    <link href="css/productpage.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <script src="js/jquery.countdown.js"></script>
    <link href="css/media.css" rel="stylesheet" type="text/css"/>
    <script>
        $(function () {
            $(".digits").countdown({
                image: "img/digits.png",
                format: "dd:hh:mm:ss",
                endTime: new Date(2013, 12, 2)
            });
        });
    </script>

</head>

<body>
<?php
include('nav.php');
if (isset($_GET["auct"])) {
    //Need auction validation
    require("dbConnection.php");
    session_start();
    $resp = $db->prepare('SELECT * FROM Auction WHERE auction_id = :auction_id');
    $resp->bindParam(':auction_id', $_GET["auct"]);
    $resp->execute();

    if ($resp->rowCount() == 0) {
        echo "Auction does not exist";
    } else {
        $data = $resp->fetch();
        $resp->closeCursor();

        $seller = $db->prepare('SELECT * FROM Users WHERE user_id = :user_id');
        $seller->bindParam(':user_id', $data["user_id"]);
        $seller->execute();

        $seller_data = $seller->fetch();
        $seller->closeCursor();

        $item = $db->prepare('SELECT * FROM Item WHERE item_id = :item_id');
        $item->bindParam(':item_id', $data["item_id"]);
        $item->execute();

        $item_data = $item->fetch();
        $item->closeCursor();

        $category = $db->prepare('SELECT * FROM Category where category_id = :category');
        $category->bindParam(':category', $item_data["category_id"]);
        $category->execute();

        $category_data = $category->fetch();
        $category->closeCursor();

        $new_view = $data['viewings'] + 1;
        $update_statement = 'UPDATE Auction SET viewings=:new WHERE auction_id = :auction';
        $stat = $db->prepare($update_statement);
        $stat->bindParam(":new", $new_view);
        $stat->bindParam(":auction", $data['auction_id']);
        $stat->execute();


        //Test data to see if it works
        //echo $data["item_id"];
        //echo $data["user_id"];
        //echo $item_data["name"];
        //echo $item_data["category_id"];
        //echo $seller_data["email"];
        //Complete
    }
} else {
    echo "Get not perceived!";
}
?>
<div class="container-fluid" style="padding-top:50px">
    <div class="content-wrapper" style="padding-top:50px">
        <div class="item-container">
            <div class="container">
                <div class="product col-md-3 service-image-left">
                    <img id="item-display"
                         src="<?php echo $item_data['item_picture']; ?>"
                         alt="">
                </div>
                <div class="product col-md-9">
                    <div class="product-title"><?php echo $item_data["label"]; ?></div>
                    <div class="product-category"><?php echo $category_data["category"]; ?></div>
                    <div class="product-rating">
                        <?php
                        $stars = round($seller_data['rating'], 0, PHP_ROUND_HALF_DOWN);
                        $diff = $seller_data['rating'] - $stars;
                        $perc = number_format(($seller_data['rating'] / 5) * 100);
                        do {
                            if ($stars == 1 && $diff < 0) {
                                echo '<span class="glyphicon glyphicon-star opacity"></span>';
                            } else {
                                echo '<span class="glyphicon glyphicon-star"></span>';
                            }
                            $stars = $stars - 1;
                        } while ($stars > 0);
                        echo "<p>  " . $perc . "% </p>";
                        ?>

                    </div>
                    <hr>
                    <div class="product-price">Current Bid
                        <br>$ <?php echo $data['current_bid']; ?>
                    </div>
                    <!--                    This is for our timer-->
                    <!--                    <div class="wrapper">-->
                    <!--                        <div class="cell">-->
                    <!--                            <div id="holder">-->
                    <!--                                <div class="digits"></div>-->
                    <!--                            </div>-->
                    <!--                        </div>-->
                    <!--                    </div>-->
                    <h5 class="product-stock"> Time Remaining: <em>10 minutes</em></h5>

<!--                    Only buyers can add bids-->
                    <?php
                    if($_SESSION['role_id']==1)
                    {
                    ?>
                        <hr>
                    <form id="addBid" action="addbid.php" method="post" role="form">
                        <input hidden name="bid_time" value="<?php echo time() ?>"/>
                        <input hidden name="user_id" value="<?php echo $_SESSION['user_id'] ?>"/>
                        <input hidden name="current_bid" value="<?php echo $data['current_bid']; ?>"/>
                        <input hidden name="auction_id" value="<?php echo $data['auction_id']; ?>"/>
                        <input type="number" id="bidInput" min="0" name="new_bid"/>
                        <button id="submit" name="submit" class="btn btn-success">Submit Bid</button>
                        <!--                            http://stackoverflow.com/questions/12230981/how-do-i-navigate-to-another-page-on-button-click-with-twitter-bootstrap-->
                    </form>
                        <hr>
                        <?php if (isset($_POST['watch']) && strcmp($_POST['watch'],'Watch Item') == 0) {
                        $sql = 'INSERT INTO Watch VALUES (:userID, :auctionID)';
                        $stmt = $db -> prepare($sql);
                        $stmt -> bindParam(':userID', $_SESSION['user_id']);
                        $stmt -> bindParam(':auctionID', $data['auction_id']);
                        $stmt -> execute();
                        $buttonName = 'Watching Item';
                        }
                        else if (isset($_POST['watch']) && strcmp($_POST['watch'],'Watching Item') == 0){
                            $sqlDel = 'DELETE FROM Watch WHERE user_id = :userID AND auction_id = :auctionID';
                            $stmtDel = $db -> prepare($sqlDel);
                            $stmtDel -> bindParam(':userID', $_SESSION['user_id']);
                            $stmtDel -> bindParam(':auctionID', $data['auction_id']);
                            $stmtDel -> execute();
                            $buttonName = 'Watch Item';
                        }
                        else {
                            $buttonName = 'Watch Item';
                        }?>
                        <form action="productpage.php" method="post" role="form">
                            <button name="watch" class="btn btn-primary" value="<?php echo $buttonName ?>"><?php echo $buttonName ?></button>
                        </form>
                    <?php
                    }
                    ?>

                    <!--
                    <div class="btn-group wishlist">
                        <button type="button" class="btn btn-danger">
                            Add to wishlist
                        </button>
                    </div>
-->
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="col-md-12 product-info">
                <ul id="myTab" class="nav nav-tabs nav_tabs">

                    <li class="active"><a href="#service-one" data-toggle="tab">DESCRIPTION</a></li>
                    <li><a href="#service-two" data-toggle="tab">AUCTION INFO</a></li>
                    <li><a href="#service-three" data-toggle="tab">BID HISTORY</a></li>

                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade in active" id="service-one">

                        <section class="container product-info">
                            <?php echo $item_data['description']; ?>
                        </section>

                    </div>
                    <div class="tab-pane fade" id="service-two">

                        <section class="container">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Field</th>
                                    <th>Value</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="info">Start Price</td>
                                    <td><?php echo $data["start_price"] . "$"; ?></td>
                                </tr>
                                <tr>
                                    <td class="info">Reserve Price</td>
                                    <td><?php echo $data["reserve_price"] . "$"; ?></td>
                                </tr>
                                <tr>
                                    <td class="info">Start Time</td>
                                    <td><?php echo $data["start_time"]; ?></td>
                                </tr>
                                <tr>
                                    <td class="info">End Time</td>
                                    <td><?php echo $data["end_time"]; ?></td>
                                </tr>
                                <tr>
                                    <td class="info">Viewings</td>
                                    <td><?php echo $data["viewings"]; ?></td>
                                </tr>
                                </tbody>
                            </table>
                        </section>

                    </div>
                    <div class="tab-pane fade" id="service-three">
                    	<section class="container">
                    		<?php
                    			$bid_history = $db->prepare('SELECT Users.first_name, Users.last_name, Bids.bid_price FROM Users,Bids WHERE auction_id = :auct AND Bids.user_id = Users.user_id ORDER BY Bids.bid_price LIMIT 10');
      							$bid_history->bindParam(':auct', $data["auction_id"]);
        						$bid_history->execute();

        						if($bid_history->rowCount() == 0){
        							echo "<p>You're the first to bid!</p>";
        						}else{
        							while($res_bid = $bid_history->fetch()){
        								echo "<p>".$res_bid["first_name"]." ".$res_bid["last_name"]." ".$res_bid["bid_price"]."</p>";
        							}
        							$bid_history->closeCursor();
        						}
                    		?>
                    	</section>
                    </div>
                </div>
                <hr>
            </div>
        </div>
    </div>
</div>
</body>

</html>