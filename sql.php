<?php

$url=parse_url(getenv('DATABASE_URL'));

//$text="host name: ".$url['host'];
//error_log($text);
//$text="path: ".substr($url['path'],1);
//error_log($text);
//$text="path: ".$url['path'];
//error_log($text);
//$text="user: ".$url['user'];
//error_log($text);
//$text="password: ".$url['pass'];
//error_log($text);
$host=$url['host'];
$dbname=substr($url['path'],1);
$user=$url['user'];
$password=$url['pass'];

    $pdo=new PDO("pgsql:host=$host;dbname=$dbname",$user,$password);
    $sql="SELECT * FROM USERS LIMIT 10;";
    $stmt=$pdo->query($sql);
    $users=$stmt->fetchAll(PDO::FETCH_OBJ);
    print_r(users);
?>
