<?php
require_once("dbconfig.php");
$error_bool = false;
$required = array('username','password','confirm-password','email');
$error_tabs = array();

foreach ($required as $field) {
	if(empty($_POST[$field])){
		$error_bool = true;
		array_push($error_tabs, $field);
	}
}

if(isset($_POST["username"],$_POST["password"],$_POST["confirm-password"],$_POST["email"]) && !$error_bool){
	//Check if passwords match
	if($_POST["confirm-password"] != $_POST["password"]){
		echo "Passwords do not match";
	}else{
		//Check if entry does not exists already
		$resp = $db->prepare('SELECT email, first_name FROM user WHERE first_name = :first_name AND email = :email');
		$resp->bindParam(':first_name',$_POST["username"]);
		$resp->bindParam(':email',$_POST["email"]);

		$resp->execute();
		//Other validations


		if($resp->rowCount() == 0){
			try{
				$ins = $db->prepare('INSERT INTO user (first_name,email,last_name) VALUES (:first_name,:email,:password)');
				$ins->bindParam(':first_name',$_POST["username"]);
				$ins->bindParam(':email',$_POST["email"]);
				$ins->bindParam(':password',$_POST["password"]);

				$ins->execute();
				echo "Registration successful";

			}catch (PDOException $e){
				echo $e->getMessage();
			}
		}else{
			echo "Username or email already taken";
		}
	}
}else{
	echo "Invalid - Absent inputs: " . implode(", ", $error_tabs);
}

?>