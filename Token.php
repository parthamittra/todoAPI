<?php
require 'vendor/autoload.php';


class Token {

	public static function createToken($id){
		$stmt=Flight::db()->prepare("insert into tokens(user_id,token) values (:userid,:token)");
		$stmt->bindParam(':userid',$id);
		$token=md5(uniqid(rand(),true));
		$stmt->bindParam(':token',$token);
		$stmt->execute();
		return $token; 

	}

	public static function validateToken($token){
		$stmt=Flight::db()->prepare("select user_id from tokens where token=:token");
		$stmt->bindValue(':token',$token);
		$stmt->execute();
		if($stmt->rowCount() ==1){
			return true;
		}else{
			return false;
		}

	}
	public static function getToken($id){
		$stmt=Flight::db()->prepare("select token from tokens where user_id=:id");
		$stmt->bindParam(':id',$id);
		$stmt->execute();
		$token=$stmt->fetchColumn();
		return $token;


	}
	
	
	public static function getUserid($token){
		$stmt=Flight::db()->prepare("select user_id from tokens where token=:token");
		$stmt->bindParam(':token',$token);
		$stmt->execute();
		$user_id=$stmt->fetchColumn();
		return $user_id;
	}
}


?>
