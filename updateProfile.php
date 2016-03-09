<?php
try{
	$sql = "UPDATE users SET username =:username, first_name =:first_name, last_name =:lastname WHERE user_id =:userID";
	$ins = $db->prepare($sql);

	$ins->bindParam(':username',$_POST["username"]);
	$ins->bindParam(':email',$_POST["email"]);
	$ins->bindParam(':password',$hashedPass);
	$ins->bindParam(':first_name',$_POST["firstname"]);
	$ins->bindParam(':last_name',$_POST["lastname"]);
	$ins->bindParam(':dob',$_POST["dob"]);

	$ins->execute();
	header();

}catch (PDOException $e){
	echo $e->getMessage();
}
?>