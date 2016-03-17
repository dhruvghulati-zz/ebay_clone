<?php 
	echo "YEAH";
	echo $_POST["user"];
	echo $_POST["rating"];
	session_start();
	
	//Push the ratings to the ratings table
	require("dbConnection.php");
	$self = $_SESSION['user_id'];
	$ins = $db->prepare('INSERT INTO Rating VALUES (:sender,:receiver,:rating_value)');

	$ins->bindParam(':sender',$self);
	$ins->bindParam(':receiver',$_POST["user"]);
    $ins->bindParam(':rating_value',$_POST["rating"]);

    $ins->execute();

    //Fetch the rated user's detail
    $fet = $db->prepare('SELECT rating_count, rating FROM Users WHERE user_id = :user LIMIT 1');
    $fet->bindParam(':user',$_POST["user"]);

    $fet->execute();
    $dat = $fet-> fetch();
    $fet->closeCursor();
    //Update to the new value fo the rating
    $new_count = $dat["rating_count"] + 1;
    $new_rating = ($dat["rating"]*$dat["rating_count"]+$_POST["rating"])/$new_count;
    
    $updt = $db->prepare('UPDATE Users SET rating=:rating,rating_count=:rating_count WHERE user_id =:user');
    
    $updt->bindParam(':rating',$new_rating);
	$updt->bindParam(':rating_count',$new_count);
    $updt->bindParam(':user',$_POST["user"]);

    $updt->execute();

    $loc = 'Location: profile.php?user='.$_POST["user"];
    header($loc);
?>