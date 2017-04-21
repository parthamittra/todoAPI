<?php
require 'vendor/autoload.php';
require 'Token.php';


class Users{



	public static function setUser(){
		$username=Flight::request()->query['username'];
	        $password=password_hash(Flight::request()->query['password'],PASSWORD_DEFAULT);
       		$firstname=Flight::request()->query['firstname'];
        	$lastname=Flight::request()->query['lastname'];





        	$stmt=Flight::db()->prepare("insert into users (username,password,firstname,lastname) values (:username, :password, :firstname,:lastname)");
        	//bind variables to the prepared statement
        	$stmt->bindParam(':username',$username);
        	$stmt->bindParam(':password',$password);
        	$stmt->bindParam(':firstname',$firstname);
        	$stmt->bindParam(':lastname',$lastname);
        	$stmt->execute();

		//return userid
		$id=Flight::db()->lastInsertId();
		$token=Token::createToken($id);
		header('Content-type: application/json');
        	echo json_encode(['id'=>$id,
                           'token'=>$token
                        ]);
		

	}


	public static function getUser(){
		$username=Flight::request()->query['username'];
	        $password=Flight::request()->query['password'];
        	$stmt=Flight::db()->prepare("select id,password from users where username=:username");
        	$stmt->bindValue(':username',$username);
		$stmt->execute();
			
		$tmp=$stmt->fetchAll();
		$id=$tmp[0]['id'];
		$password_hash=$tmp[0]['password'];
		
		$token=Token::getToken($id);	
		if(password_verify($password,$password_hash)){
			header('Content-type: application/json');
			echo json_encode(['id'=>$id,
					    'token'=>$token
					   ]);	
		}
	}





}





?>
