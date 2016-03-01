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

</head>

<body>
    <?php include('nav.html'); 
        if(isset($_GET["auct"])){
            //Need auction validation
            require("dbconfig.php");
            $resp = $db->prepare('SELECT * FROM auction WHERE auction_id = :auction_id');
            $resp->bindParam(':auction_id',$_GET["auct"]);
            $resp->execute();

            if($resp->rowCount() == 0){
                echo "Auction does not exist";
            }else{
                $data = $resp->fetch();
                $resp->closeCursor();

                $seller = $db->prepare('SELECT * FROM users WHERE user_id = :user_id');
                $seller->bindParam(':user_id',$data["user_id"]);
                $seller->execute();

                $seller_data = $seller->fetch();
                $seller->closeCursor();

                $item = $db->prepare('SELECT * FROM item WHERE item_id = :item_id');
                $item->bindParam(':item_id',$data["item_id"]);
                $item->execute();
                
                $item_data = $item->fetch();
                $item->closeCursor();
                
                //Test data to see if it works
                //echo $data["item_id"];
                //echo $data["user_id"];
                //echo $item_data["name"];
                //echo $item_data["category_id"];
                //echo $seller_data["email"];
                //Complete 
            }
        }else{
            echo "Get not perceived!";
        }
    ?>
    <div class="container-fluid" style="padding-top:50px">
        <div class="content-wrapper" style="padding-top:50px">
            <div class="item-container">
                <div class="container">
                        <div class="product col-md-3 service-image-left">
                                <img id="item-display" src="http://www.sammobile.com/wp-content/uploads/2012/08/Samsung-ATIV-Tab-Product-Image-5.jpg" alt="">
                        </div>
                    <div class="product col-md-9">
                        <div class="product-title"><?php echo $item_data["name"]; ?></div>
                        <div class="product-category"><?php echo $item_data["category_id"]; ?></div>
                        <div class="product-title">
                            <?php 
                                $stars = round($seller_data['rating'],0,PHP_ROUND_HALF_DOWN);
                                $diff = $seller_data['rating'] - $stars;
                                $perc = number_format(($seller_data['rating']/5)*100);
                                do{
                                  if($stars == 1 && $diff< 0){
                                      echo '<span class="glyphicon glyphicon-star opacity"></span>';    
                                   }else{
                                     echo '<span class="glyphicon glyphicon-star"></span>';
                                     }  
                                     $stars = $stars - 1;
                                 }while($stars>0);
                                 echo "<p>  ".$perc."% </p>";
                             ?>

                        </div>
                        <div class="product-rating"><i class="fa fa-star gold"></i> <i class="fa fa-star gold"></i> <i class="fa fa-star gold"></i> <i class="fa fa-star gold"></i> <i class="fa fa-star-o"></i> </div>
                        <hr>
                        <div class="product-price">Current_bid/end_price
                            <br>$ 1234.00</div>
                        <h5 class="product-stock"> Time Remaining: <em>10 minutes</em></h5>
                        <hr>
                        <div>
                            <input type="number" id="replyNumber" min="0" data-bind="value:replyNumber" />
                        </div>
                        <div class="btn-group cart" style="padding-top:10px">
                            <button type="button" class="btn btn-success">
                                Submit Bid
                            </button>
                            <!--                            http://stackoverflow.com/questions/12230981/how-do-i-navigate-to-another-page-on-button-click-with-twitter-bootstrap-->
                        </div>
                        <hr>
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

                    </ul>
                    <div id="myTabContent" class="tab-content">
                        <div class="tab-pane fade in active" id="service-one">

                            <section class="container product-info">
                                The Corsair Gaming Series GS600 power supply is the ideal price-performance solution for building or upgrading a Gaming PC. A single +12V rail provides up to 48A of reliable, continuous power for multi-core gaming PCs with multiple graphics cards. The ultra-quiet, dual ball-bearing fan automatically adjusts its speed according to temperature, so it will never intrude on your music and games. Blue LEDs bathe the transparent fan blades in a cool glow. Not feeling blue? You can turn off the lighting with the press of a button.

                                <h3>Corsair Gaming Series GS600 Features:</h3>
                                <li>It supports the latest ATX12V v2.3 standard and is backward compatible with ATX12V 2.2 and ATX12V 2.01 systems</li>
                                <li>An ultra-quiet 140mm double ball-bearing fan delivers great airflow at an very low noise level by varying fan speed in response to temperature</li>
                                <li>80Plus certified to deliver 80% efficiency or higher at normal load conditions (20% to 100% load)</li>
                                <li>0.99 Active Power Factor Correction provides clean and reliable power</li>
                                <li>Universal AC input from 90~264V — no more hassle of flipping that tiny red switch to select the voltage input!</li>
                                <li>Extra long fully-sleeved cables support full tower chassis</li>
                                <li>A three year warranty and lifetime access to Corsair’s legendary technical support and customer service</li>
                                <li>Over Current/Voltage/Power Protection, Under Voltage Protection and Short Circuit Protection provide complete component safety</li>
                                <li>Dimensions: 150mm(W) x 86mm(H) x 160mm(L)</li>
                                <li>MTBF: 100,000 hours</li>
                                <li>Safety Approvals: UL, CUL, CE, CB, FCC Class B, TÜV, CCC, C-tick</li>
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
                                    <td><?php echo $data["start_price"]."$"; ?></td>
                                </tr>
                                <tr>
                                    <td class="info">Reserve Price</td>
                                    <td><?php echo $data["start_price"]."$"; ?></td>
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
                    </div>
                    <hr>
                </div>
            </div>
        </div>
    </div>
</body>

</html>