<?php
require_once 'dbConnection.php';
?>

<?php
if (isset($_POST['submit'])) {
    $name = $_POST['item-name'];
    $category = $_POST['item-category'];
    $description = $_POST['item-description'];
    $state = $_POST['item-state'];
    $startPrice = $_POST['start-price'];
    $reservePrice = $_POST['reserve-price'];
    $auctionDuration = $_POST['auction-duration'];
    $image_name = $_FILES['item-image']['name'];
    $tmp_name = $_FILES['item-image']['tmp_name'];
    $saveddate = date('mdy-Hms');
    $newfilename = 'uploads/item/'.$saveddate.'_'.$image_name;
    if (isset($image_name)) {
        if (!empty($image_name)) {
            move_uploaded_file($tmp_name, $newfilename);
        }
    }
    $startdate = new DateTime();
    $enddate = $startdate;
    $formatstart = $startdate -> format('Y-m-d H:i:s');
    $sql = 'SELECT duration FROM Duration WHERE duration_id = '.$auctionDuration;
    $result=$db->query($sql);
    $row = $result -> fetch();
    $value = $row['duration'];
    $enddate = $enddate->modify('+'.$value.' day');
    $formatend = $enddate -> format('Y-m-d H:i:s');
    $itemSQL = 'INSERT INTO Item VALUES (NULL, :item_picture, :label, :description, :state_id, :category_id)';
    $auctionSQL = 'INSERT INTO Auction VALUES (NULL, :start_price, :reserve_price, 0, :start_time, :duration_id, :end_time,
              DEFAULT, LAST_INSERT_ID(), 1)';
    $itemSTMT = $db -> prepare($itemSQL);
    $itemSTMT->bindParam(':item_picture', $newfilename);
    $itemSTMT->bindParam(':label', $name);
    $itemSTMT->bindParam(':description', $description);
    $itemSTMT->bindParam(':state_id', $state);
    $itemSTMT->bindParam(':category_id', $category);
    $auctionSTMT = $db -> prepare($auctionSQL);
    $auctionSTMT->bindParam(':start_price', $startPrice);
    $auctionSTMT->bindParam(':reserve_price', $reservePrice);
    $auctionSTMT->bindParam(':start_time', $formatstart);
    $auctionSTMT->bindParam(':duration_id', $auctionDuration);
    $auctionSTMT->bindParam(':end_time', $formatend);
    $db->beginTransaction();
    $itemSTMT->execute();
    if (!$itemSTMT ->rowCount()) {
        $db->rollBack();
        echo 'item stmt failed';
    }
    else {
        $auctionSTMT ->execute();
        if (!$auctionSTMT ->rowCount()) {
            $db->rollBack();
            echo 'auction stmt failed';
        }
        else {
            $db->commit();
            echo 'success db';
            header('Location: listings.php');
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <title>Add Auction</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</head>

<body>



    <form class="form-horizontal" style="padding-top:50px" role="form" method="post" action="addauction.php" enctype="multipart/form-data">
        <fieldset style="padding-top:50px">
            <!-- Item Name -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="item-name">Product Name</label>
                <div class="col-md-4">
                    <input id="item-name" name="item-name" placeholder="Product Name" class="form-control">
                </div>
            </div>
            <!-- Item Category -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="item-category">Product Category</label>
                <div class="col-md-4">
                    <select id="item-category" name="item-category" class="form-control">
                        <option selected disabled hidden>Please Select a Category</option>
                        <?php
                        $sql = 'SELECT * FROM Category';
                        foreach ($db -> query($sql) as $row) { ?>
                        <option value = "<?php echo $row['category_id']; ?>"><?php echo $row['category']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <!-- Item Description -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="item-description">Product Description</label>
                <div class="col-md-4">
                    <textarea class="form-control" id="item-description" name="item-description" style="resize:none"></textarea>
                </div>
            </div>
            <!-- Item State -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="item-state">Product Condition</label>
                <div class="col-md-4">
                    <select id="item-state" name="item-state" class="form-control">
                        <option value="" selected disabled hidden>Please Select a Condition</option>
                        <?php
                        $sql = 'SELECT * FROM State';
                        foreach ($db -> query($sql) as $row) { ?>
                        <option value = "<?php echo $row['state_id']; ?>"><?php echo $row['state']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <!-- Start Price -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="start-price">Start Price</label>
                <div class="col-md-4">
                    <input id="start-price" name="start-price" placeholder="Start Price" class="form-control">
                </div>
            </div>
            <!-- Reserve Price -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="reserve-price">Reserve Price</label>
                <div class="col-md-4">
                    <input id="reserve-price" name="reserve-price" placeholder="Reserve Price" class="form-control">
                </div>
            </div>
            <!-- Auction Duration -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="auction-duration">Auction Duration</label>
                <div class="col-md-4">
                    <select id="auction-duration" name="auction-duration" class="form-control">
                        <option value="" selected disabled hidden>Please Select the Auction Duration</option>
                        <?php
                        $sql = 'SELECT * FROM Duration';
                        foreach ($db -> query($sql) as $row) { ?>
                            <option value = "<?php echo $row['duration_id']; ?>"><?php echo $row['duration']; ?> Days</option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <!-- Item Image -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="item-image">Upload Image</label>
                <div class="col-md-4">
                    <input id="item-image" name="item-image" class="input-file" type="file">
                </div>
            </div>
            <!-- Submit Auction -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="submit">Ready to Submit?</label>
                <div class="col-md-4">
                    <button id="submit" name="submit" class="btn btn-primary">Submit to Listings</button>
                </div>
            </div>
        </fieldset>
    </form>

</body>

</html>