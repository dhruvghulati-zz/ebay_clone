<?php
require_once("dbconfig.php");
$error_bool = false;
$required = array('username','password','confirm-password','email','firstname','lastname','dob');
$error_tabs = array();

foreach ($required as $field) {
	if(empty($_POST[$field])){
		$error_bool = true;
		array_push($error_tabs, $field);
	}
}

if(isset($_POST["username"],$_POST["password"],$_POST["confirm-password"],$_POST["email"],$_POST["dob"],$_POST["firstname"], $_POST["lastname"]) && !$error_bool){
	//Check if passwords match
	if($_POST["confirm-password"] != $_POST["password"]){
		echo "Passwords do not match";
	}else{
		//Check if entry does not exists already
		$resp = $db->prepare('SELECT username,email FROM users WHERE username = :username AND email = :email');
		$resp->bindParam(':username',$_POST["username"]);
		$resp->bindParam(':email',$_POST["email"]);

		$resp->execute();
		//Other validations


		if($resp->rowCount() == 0){
			try{
				$ins = $db->prepare('INSERT INTO users (username,password,first_name,email,last_name,birthdate) VALUES (:username,:password,:first_name,:email,:last_name,:dob)');
				
				$hashedPass = sha1($_POST["password"],false);

				$ins->bindParam(':username',$_POST["username"]);
				$ins->bindParam(':email',$_POST["email"]);
				$ins->bindParam(':password',$hashedPass);
				$ins->bindParam(':first_name',$_POST["firstname"]);
				$ins->bindParam(':last_name',$_POST["lastname"]);
				$ins->bindParam(':dob',$_POST["dob"]);

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