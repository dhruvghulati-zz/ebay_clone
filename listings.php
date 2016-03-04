<?php include_once 'dbConnection.php';

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

<?php
include 'nav.php';
?>

<div class="container">
    <?php
    echo $_SESSION['user_id'];
    echo $_SESSION['role_id'];
    ?>
</div>

<script>
    $(document).ready(function(){
        $('#searchButton').click(function(){
            //Get values inserted
            var query = $('#textSearch').val();
            var cat = $('#item-category').val();
            var state = $('#item-state').val();
            var sort = $('#item-sort').val();
//            Change the URL
            window.open('listings.php?q=' + query + '&cat=' + cat + '&state=' + state + '&sort=' + sort,'_self');
        })
        $('#textSearch').keypress(function(e){
            if(e.which == 13){//Enter key pressed
                $('#searchButton').click();//Trigger search button click event
            }
        });

    });
</script>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="input-group" id="adv-search">
                <input id="textSearch" type="text" class="form-control" placeholder="Search for auctions by name or description"/>
                <div class="input-group-btn">
                    <div class="btn-group" role="group">
                        <div class="dropdown dropdown-lg">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                                    aria-expanded="false"><span class="caret"></span></button>
                            <div class="dropdown-menu dropdown-menu-right" role="menu">
                                <form class="form-horizontal" role="form">
<!--                                    Sort related to time-->
                                    <div class="form-group">
                                        <label for="filter">Sort By</label>
                                        <select class="form-control" id="item-sort" name="sort">
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
                                                    value="<?php echo $row['category_id']; ?>"><?php echo htmlspecialchars($row['category']); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="filter">Filter by State</label>
                                        <select class="form-control" id="item-state" name="state">
                                            <option value="" selected disabled hidden>Please Select a
                                                Condition
                                            </option>
                                            <?php $sql = 'SELECT * FROM State';
                                            foreach ($db->query($sql) as $row) { ?>
                                                <option
                                                    value="<?php echo $row['state_id']; ?>"><?php echo htmlspecialchars($row['state']); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary"><span
                                            class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                                </form>
                            </div>
                        </div>
                        <button id="searchButton" type="button" class="btn btn-primary"><span class="glyphicon glyphicon-search"
                                                                            aria-hidden="true"></span></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- Page Content -->
    <!--        Start listings of auctions-->
    <div class="col-md-9">
        <div id="auction_list" class="row" style="padding-top:50px">
            <?php
            try {
                //Get the default SQL statement
                //Need to account for the fact that the order by clause will be offset by a different order.
                $aucsql = 'SELECT * FROM Auction a
                INNER JOIN Item i ON i.item_id = a.item_id
                INNER JOIN Users u ON u.user_id = a.user_id
                INNER JOIN Category c ON i.category_id = c.category_id';

//                echo $aucsql;

//                ORDER BY (((NOW()-1) - (end_time-1)) * 86400000) ASC';
                $category="";
                $q="";
                $state="";
                $sort="";

                //Get the URL parameters which are sent via the search form when a search is placed
//              http://stackoverflow.com/questions/18271173/php-check-if-url-parameter-exists
                if (isset($_GET['cat']) && $_GET['cat']!='null') {
                    $category = trim($_GET['cat']);
                }
                if (isset($_GET['q']) && $_GET['q']!="") {
                    $q = trim($_GET['q']);
                }
                if (isset($_GET['state']) && $_GET['state']!='null') {
                    $state = trim($_GET['state']);
                }
                if (isset($_GET['sort']) && $_GET['sort']!='null') {
                    $sort = trim($_GET['sort']);
                }

//                echo $sort;
//                echo $state;
//                echo $q;
//                echo $category;

                $conditions = array();
                $order = "";

                if ($q != "") {
                    $conditions[] = "(i.label LIKE '%$q%' OR i.description LIKE '%$q%')";
                }
                if ($state != "") {
                    //Need to convert the state back to upper case and reverse the slashes
                    $conditions[] = "i.state_id='$state'";
                }
                if ($category != "") {
                    //Need to convert the category back to upper case and reverse the slashes
                    $conditions[] = "i.category_id='$category'";
                }
                if ($sort != "" && $sort = 'lowest_price') {
                    $order = "ORDER BY a.current_bid ASC";
                }
                if ($sort != "" && $sort = 'highest_price') {
                    $order = "ORDER BY a.current_bid DESC";
                }
//                $enddt = strtotime(a.end_time);
//                $daysremaining = date("z", $enddt) - date("z");
                if ($sort != "" && $sort = 'lowest_time_remaining') {
                    $order = "ORDER BY abs(date(a.end_time)-date(now())) ASC";
                }
                if ($sort != "" && $sort = 'highest_time_remaining') {
                    $order = "ORDER BY abs(date(a.end_time)-date(now())) ASC";
                }
                if (count($conditions) > 0) {
                    $aucsql .= " WHERE " . implode(' AND ', $conditions) . ' ' . $order;
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
                                    echo htmlspecialchars($auction['label'])
                                    ?>
                                </a>
                            </h4>
                            <p>
                                <?php
                                echo htmlspecialchars($auction['description'])
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