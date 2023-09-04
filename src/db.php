<?php

$db_host = "localhost";
$db_name = "blog";
$db_username = "root";
$db_password = "";
$db_options = [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ];

try{
  $pdo = new PDO( "mysql:host=$db_host;dbname=$db_name", $db_username, $db_password, $db_options );

} catch( \Throwable $e){
  echo $e;
}