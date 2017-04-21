<?php
require 'vendor/autoload.php';
require_once 'Token.php';


class Lists{


	public static function setList(){
		$token=Flight::request()->query['token'];
	        $list_name=Flight::request()->query['list_name'];
		if(!Token::validateToken($token)){
			return Flight::json(['error'=>'bad parameters'],400);
		}
		
		$user_id=Token::getUserid($token);
        	$stmt=Flight::db()->prepare("insert into lists (user_id,name) values (:user_id,:list_name)");
        	//bind variables to the prepared statement
		$stmt->bindParam(':user_id',$user_id);
        	$stmt->bindParam(':list_name',$list_name);
        	$stmt->execute();

		//return userid
		$id=Flight::db()->lastInsertId();
		header('Content-type: application/json');
        	echo json_encode(['list_id'=>$id,
                           'list_name'=>$list_name
                        ]);
			

		
	}

	public static function deleteList($id){
		$stmt=Flight::db()->prepare("delete from lists where id=:id");
		$stmt->bindParam(':id',$id);
		$stmt->execute();
		if($stmt->rowCount()==1){
			return  Flight::json(null,204);
		}
		return Flight::json(['error'=>'delete failed',400]);





	}
	public static function getList(){
	        

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
