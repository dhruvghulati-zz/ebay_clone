<?php include 'dbConnection.php';
include 'search.php';
echo search_auctions('fiat');
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- Custom CSS -->
    <link href="css/shop-homepage.css" rel="stylesheet">
    <link href="css/dropdown.css" rel="stylesheet">
    <!-- jQuery -->
<!--    Decided to use CDN not JQuery script-->
    <script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
</head>

<body>


<!-- Navigation -->
<!--    Support paging via http://www.tutorialspoint.com/php/mysql_paging_php.htm-->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">eBuy Platform</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li>
                    <a href="profile.html">Your Profile</a>
                </li>
                <li>
                    <a href="listings.html">Live Listings</a>
                </li>
                <li>
                    <!--                       This should be dependent on your user type-->
                    <a href="mybids.html">Your Bids/Your Auctions</a>
                </li>
                <li>
                    <!--                       This should be depending on user type-->
                    <a href="addauction.html">Submit Auction</a>
                </li>
                <li>
                    <a href="index.html">Logout</a>
                </li>

            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
    <!--        End of the navigation bar-->
</nav>

<!--Container for categories-->
<!--<div class="container">-->
<!--    <div class="row">-->
<!--        --><?php
//        try {
//            //         error_reporting(E_ERROR | E_PARSE);
//            $catsql = 'SELECT * FROM ebay_clone.Category';
//            $catq = $db->query($catsql);
//            $catq->setFetchMode(PDO::FETCH_ASSOC);
//        } catch (PDOException $e) {
//            echo 'ERROR: ' . $e->getMessage();
//        }
//        ?>
<!---->
<!--        <div class="col-md-12" style="padding-top:50px">-->
<!--            <p class="lead">Username</p>-->
<!--            <div class="list-group list-group-horizontal">-->
<!--                --><?php //while ($r = $catq->fetch()): ?>
<!--                    <a href="#" class="list-group-item">--><?php //echo htmlspecialchars($r['item_category']) ?><!--</a>-->
<!--                --><?php //endwhile; ?>
<!--            </div>-->
<!--        </div>-->
<!--        <!--            End of row of categories-->-->
<!--    </div>-->
<!--</div>-->

<script>
    $(document).ready(function(e){
        $("#auction").keyup(function()
        {
            $("#auction").show();
            var x = $(this).val();
            $.ajax(
                {
                    type: 'GET',
                    url: 'search.php',
                    data: 'q='+x,
                    success:function(data)
                    {
                        $("#auction").html(data);
                        console.log(data);
                    }
                    ,
                });
        });
    });
</script>


<!-- Page Content -->
<div class="container">
    <!--This is the search bar-->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="input-group" id="adv-search">
                    <input type="text" name="by_name_description" method="post" class="form-control"
                           placeholder="Search for auctions by name or description"/>
                    <div class="input-group-btn">
                        <div class="btn-group" role="group">
                            <div class="dropdown dropdown-lg">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                                        aria-expanded="false"><span class="caret"></span></button>
                                <div class="dropdown-menu dropdown-menu-right" role="menu">

                                    <form class="form-horizontal" role="form" method="post">
                                        <div class="form-group">
                                            <label for="filter">Sort By</label>
                                            <select class="form-control">
                                                <option value="by_lowest_time" selected>Lowest Time Remaining</option>
                                                <option value="by_highest_time">Highest Time Remaining</option>
                                                <option value="by_lowest_price">Lowest Price</option>
                                                <option value="by_highest_price">Highest Price</option>
                                                <option value="by_oldest">Oldest</option>
                                                <option value="by_newest">Newest</option>
                                            </select>
                                        </div>
                                        <!--                                            This could be removed if you want the category search above-->
                                        <div class="form-group" method="post">
                                            <label for="filter">Filter by Category</label>
                                            <?php
                                            try {
                                                //         error_reporting(E_ERROR | E_PARSE);
                                                $catsql = 'SELECT * FROM ebay_clone.Category';
                                                $catq = $db->query($catsql);
                                                $catq->setFetchMode(PDO::FETCH_ASSOC);
                                            } catch (PDOException $e) {
                                                echo 'ERROR: ' . $e->getMessage();
                                            }
                                            ?>
                                            <select class="form-control" method="post">
                                                <?php while ($r = $catq->fetch()): ?>
                                                    <option
                                                        value=<?php str_replace(' ', '-', strtolower($r['item_category'])) ?>> <?php echo htmlspecialchars($r['item_category']) ?></option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>

                                        <div class="form-group" method="post">
                                            <label for="contain">Filter By Seller</label>
                                            <input class="form-control" type="text" name="by_seller"
                                                   placeholder="Search by seller name"/>
                                        </div>
                                        <button type="submit" name="submit" class="btn btn-primary"><span
                                                class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                                    </form>

                                </div>

                            </div>
                            <button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-search"
                                                                                aria-hidden="true"></span></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--        Start listings of auctions-->
    <div class="col-md-9">
        <div id="auction_list" class="row" style="padding-top:50px">
            <?php
            try {
                //         error_reporting(E_ERROR | E_PARSE);
                //This ordering works but it is ordering and changing the prices, not the actual products.
                //Need to change to a huge sql statement
                //http://stackoverflow.com/questions/11617962/calculating-difference-between-two-timestamps-in-oracle-in-milliseconds
                $aucsql = 'SELECT * FROM ebay_clone.Auction a
                INNER JOIN ebay_clone.Item i ON i.item_id = a.item_id
                INNER JOIN ebay_clone.Users u ON u.user_id = a.user_id
                ORDER BY (((NOW()-1) - (end_time-1)) * 86400000) ASC';
                $aucq = $db->query($aucsql);
                $aucq->setFetchMode(PDO::FETCH_ASSOC);

            } catch (PDOException $e) {
                echo 'ERROR: ' . $e->getMessage();
            }
            ?>
            <div id="auction" class="col-sm-4 col-lg-4 col-md-4">
                <!--                Should these go into a sorted array? http://www.w3schools.com/php/func_array_sort.asp-->
                <?php while (($auction = $aucq->fetch())): ?>

                    <div class="thumbnail">
                        <img src="http://placehold.it/320x150" alt="">
                        <div class="caption">
                            <h4 class="pull-right"><?php
                                echo htmlspecialchars($auction['current_bid']) ?></h4>
                            <h4><a href="productpage.html">
                                    <?php
                                    echo htmlspecialchars($auction['name'])
                                    ?>
                                </a>
                            </h4>
                            <p>
                                <?php
                                echo htmlspecialchars($auction['features'])
                                ?>
                            </p>
                        </div>
                        <div class="ratings pull-right">
                            <?php
                            echo abs(min(time(),$auction['end_time']) - max($auction['end_time'],time()))/(60*60*24);
                            ?>
                            </div>
                        <div class="ratings">
                            <p class="pull-right"><?php
                                echo htmlspecialchars($auction['viewings']) . ' Viewings'
                                ?>
                            </p>
                            <p>
                                <?php
                                if (is_array($auction) || is_object($auction)) {
//Check if this works as ratings can be a decimal value too e.g. 3.45. We should also ensure ratings are a incremental figure
                                    for ($x = 0; $x <= intval($auction['rating'] - 1); $x++) {
                                        echo '<span class="glyphicon glyphicon-star"></span>';
                                    }
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>

        </div>
    </div>

    <!-- /.container -->


</body>


</html>