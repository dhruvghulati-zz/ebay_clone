<?php
require_once 'dbConnection.php';
session_start();
?>

<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">

        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="listings.php">eBuy Platform</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li>
                    <a href="profile.php"><?php echo $_SESSION['first_name']?></a>
                </li>
                <li>
                    <?php
                    if ($_SESSION['role_id'] == 2) {
                        echo '<a href="bidsauctions.php">Your Auctions</a>';
                    }
                    else if ($_SESSION['role_id'] == 1) {
                        echo '<a href="bidsauctions.php">Your Bids</a>';
                    }
                    ?>
                </li>
                <li>
                    <?php
                    if ($_SESSION['role_id'] == 2) {
                        echo '<a href="addauction.php">Submit Auction</a>';
                    }
                    ?>
                </li>
                <li>
                    <a href="logout.php">Logout</a>
                </li>
            </ul>
            <form class="navbar-form navbar-right" role="form" method="get" action="listings.php">
                <!-- Search Name -->
                <div class="form-group">
                    <label class="sr-only" for="item-name">Product Name</label>
                    <input id="item-name" name="search-name" placeholder="Product Name or Description" class="form-control">
                </div>
                <!-- Search Category -->
                <div class="form-group">
                    <label class="sr-only" for="item-category">Product Category</label>
                    <select id="item-category" name="search-category" class="form-control">
                        <option value = "0" selected>All Categories</option>
                        <?php
                        $sql = 'SELECT * FROM Category';
                        foreach ($db -> query($sql) as $row) { ?>
                            <option value = "<?php echo $row['category_id']; ?>"><?php echo $row['category']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <!-- Search State -->
                <div class="form-group">
                    <label class="sr-only" for="item-state">Product Condition</label>
                    <select id="item-state" name="search-state" class="form-control">
                        <option value = "0" selected>All Conditions</option>
                        <?php
                        $sql = 'SELECT * FROM State';
                        foreach ($db->query($sql) as $row) { ?>
                            <option value="<?php echo $row['state_id']; ?>"><?php echo $row['state']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <!-- Search Auction -->
                <div class="form-group">
                    <label class="sr-only" for="submit">Search</label>
                    <button id="submit" name="sort" value="1" class="btn btn-primary" type="hidden">Search</button>
                </div>
            </form>
        </div>
    </div>
</nav>