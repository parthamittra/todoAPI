<?php
require 'vendor/autoload.php';
require_once 'Token.php';


class Items{


	public static function setItem($list_id){
		$token=Flight::request()->query['token'];
	        $item_value=Flight::request()->query['item_value'];
		if(!Token::validateToken($token)){
			return Flight::json(['error'=>'bad parameters'],400);
		}
		
		$user_id=Token::getUserid($token);
        	$stmt=Flight::db()->prepare("insert into items (list_id,item,status) values (:list_id,:item,'pending')");
        	//bind variables to the prepared statement
		$stmt->bindParam(':list_id',$list_id);
        	$stmt->bindParam(':item',$item_value);
        	$stmt->execute();

		$id=Flight::db()->lastInsertId();
		header('Content-type: application/json');
        	echo json_encode(['item_id'=>$id
                        ]);
			

		
	}

	public static function deleteItem($item_id){
		$stmt=Flight::db()->prepare("delete from items where id=:id");
		$stmt->bindParam(':id',$item_id);
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
