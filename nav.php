<?php
include 'dbConnection.php';
?>
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
            <a class="navbar-brand" href="listings.php">eBuy Platform</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li>
                    <a href="profile.php">Your Profile</a>
                </li>
                <li>
                    <?php
                    if ($_SESSION['role_id'] == 1) {
                        echo '<a href="mybids.html">Your Auctions</a>';
                    } else if ($_SESSION['role_id'] == 2) {
                        echo '<a href="mybids.html">Your Bids</a>';
                    }
                    ?>
                    <!--                       This should be dependent on your user type-->

                </li>
                <?php
                if ($_SESSION['role_id'] == 1) {
                    echo '<li><a href="addauction.php">Submit Auction</a></li>';
                }
                ?>
                <li>
                    <a href="logout.php">Logout</a>
                </li>

            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
    <!--        End of the navigation bar-->
</nav>