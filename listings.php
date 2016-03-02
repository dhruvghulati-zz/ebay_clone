<?php include_once 'dbConnection.php';
//include 'search.php';
//echo search_auctions('fiat');
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

<!--<script>-->
<!--    $(document).ready(function (e) {-->
<!--        $("#auction").keyup(function () {-->
<!--            $("#auction").show();-->
<!--            var x = $(this).val();-->
<!--            $.ajax(-->
<!--                {-->
<!--                    type: 'GET',-->
<!--                    url: 'search.php',-->
<!--                    data: 'q=' + x,-->
<!--                    success: function (data) {-->
<!--                        $("#auction").html(data);-->
<!--                        console.log(data);-->
<!--                    }-->
<!--                    ,-->
<!--                });-->
<!--        });-->
<!--    });-->
<!--</script>-->
<div class="container">

    dfdfads
</div>

<!-- Page Content -->
<div class="container">
    <!--This is the search bar-->
    <div class="container">
        <div class="row">
            <form action="listings.php" method="get">
                <div class="col-sm-12">
                    <div class="input-group" id="adv-search">
                        <input type="text" name="q" class="form-control"
                               placeholder="Search for auctions by name or description" value=""/>
                        <div class="input-group-btn">
                            <div class="btn-group" role="group">
                                <div class="dropdown dropdown-lg">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                                            aria-expanded="false"><span class="caret"></span></button>
                                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                                        <div class="form-horizontal" role="form">
                                            <div class="form-group">
                                                <label for="filter">Sort By</label>
                                                <select class="form-control" name="sort" value="by_lowest_time">
                                                    <!--                                                By default by lowest time remaining-->
                                                    <option value="by_lowest_time" selected>Lowest Time Remaining
                                                    </option>
                                                    <option value="by_highest_time">Highest Time Remaining</option>
                                                    <option value="by_lowest_price">Lowest Price</option>
                                                    <option value="by_highest_price">Highest Price</option>
                                                </select>
                                            </div>
                                            <!-- Item Category -->
                                            <div class="form-group">
                                                <label for="filter">Filter by Category</label>
                                                <select class="form-control" id="item-category" name="cat">
                                                    <option value="" selected disabled hidden>Please Select a Category
                                                    </option>
                                                    <?php $sql = 'SELECT * FROM Category';
                                                    foreach ($db->query($sql) as $row) { ?>
                                                        <option
                                                            value="<?php echo $row['item_category']; ?>"><?php echo htmlspecialchars($row['item_category']); ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <!-- Item State -->
                                            <div class="form-group">
                                                <label for="filter">Filter by State</label>
                                                <select class="form-control" id="item-state" name="state">
                                                    <option value="" selected disabled hidden>Please Select a
                                                        Condition
                                                    </option>
                                                    <?php $sql = 'SELECT * FROM State';
                                                    foreach ($db->query($sql) as $row) { ?>
                                                        <option
                                                            value="<?php echo $row['state']; ?>"><?php echo htmlspecialchars($row['state']); ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <button type="submit"
                                                    class="btn btn-primary"><span
                                                    class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"
                                                                                    aria-hidden="true"></span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <!--        Start listings of auctions-->
    <div class="col-md-9">
        <div id="auction_list" class="row" style="padding-top:50px">
            <?php
            try {
                //Get the default SQL statement
                //Need to account for the fact that the order by clause will be offset by a different order.
                $aucsql = 'SELECT * FROM ebay_clone.Auction a
                INNER JOIN ebay_clone.Item i ON i.item_id = a.item_id
                INNER JOIN ebay_clone.Users u ON u.user_id = a.user_id
                INNER JOIN ebay_clone.Category c ON i.category_id = c.category_id';

//                echo $aucsql;

//                ORDER BY (((NOW()-1) - (end_time-1)) * 86400000) ASC';

                //Get the URL parameters which are sent via the search form when a search is placed
//              http://stackoverflow.com/questions/18271173/php-check-if-url-parameter-exists
                if (isset($_GET['cat'])) {
                    $category = trim($_GET['cat']);
                }
                if (isset($_GET['q'])) {
                    $q = trim($_GET['q']);
                }
                if (isset($_GET['state'])) {
                    $state = trim($_GET['state']);
                }
                if (isset($_GET['sort'])) {
                    $sort = trim($_GET['sort']);
                }

                $conditions = array();

                if ($q != "") {
                    $conditions[] = "(i.name LIKE '%$q%' OR i.features LIKE '%$q%')";
                }
                if ($state != "") {
                    //Need to convert the state back to upper case and reverse the slashes
                    $conditions[] = "i.state='$state'";
                }
                if ($category != "") {
                    //Need to convert the category back to upper case and reverse the slashes
                    $conditions[] = "i.item_category='$category'";
                }
                if ($sort != "" && $sort = 'lowest_price') {
                    $conditions[] = "ORDER BY a.current_bid ASC";
                }
                if ($sort != "" && $sort = 'highest_price') {
                    $conditions[] = "ORDER BY a.current_bid DESC";
                }
                if ($sort != "" && $sort = 'lowest_time_remaining') {
                    $conditions[] = "ORDER BY abs(date(a.end_time)-date(now()) ASC";
                }
                if ($sort != "" && $sort = 'highest_time_remaining') {
                    $conditions[] = "ORDER BY ORDER BY abs(date(a.end_time)-date(now()) ASC";
                }
                if (count($conditions) > 0) {
                    $aucsql .= " WHERE " . implode(' AND ', $conditions);
                }

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
                            <!--                            This should have something to add a value to viewings-->
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
                            echo abs(min(time(), $auction['end_time']) - max($auction['end_time'], time())) / (60 * 60 * 24);
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