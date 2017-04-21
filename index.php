<?php

require 'vendor/autoload.php';
require 'Users.php';
require 'Lists.php';
require 'Items.php';


Flight::register('db', 'PDO', array('mysql:host=localhost;port=3306;dbname=todoAPI', 'root', 'pa55w0rd'), function($db) {
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'utf8'");
        $db->exec("SET NAMES 'utf8';");
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, 0);
});



Flight::route('POST /api/v1/users',array('Users','setUser'));
Flight::route('GET /api/v1/users',array('Users','getUser')); 
Flight::route('POST /api/v1/lists',array('Lists','setList'));
Flight::route('DELETE /api/v1/lists/@id',array('Lists','deleteList'));
Flight::route('POST /api/v1/lists/@list_id/items',array('Items','setItem'));
Flight::route('DELETE /api/v1/lists/items/@item_id',array('Items','deleteItem'));
Flight::start();

?>
