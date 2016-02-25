<?php
require("dbconfig.php");

if(isset($_POST["username"],$_POST["password"])){
	
	$resp = $db->prepare('SELECT user_id, first_name FROM user WHERE first_name = :first_name AND last_name = :password');
	$resp->bindParam(':first_name',$_POST["username"]);
	$resp->bindParam(':password',$_POST["password"]);

	$resp->execute();

	if($resp->rowCount() == 0){
		echo "Invalid";
		header("Location: index.html");
	}else{
		$data = $resp->fetch();
		session_start();
		$y = $data["user_id"];
		$_SESSION["user_id"] = $y;
		$_SESSION["first_name"] = $data["first_name"];
		header("Location: profile.php");
	}
}else{
	echo "Invalid";
	header("Location: index.html");
}
?>