<?php

$url=parse_url(getenv('DATABASE_URL'));

$text="host name: ".$url['host'];
error_log($text);
$text="path: ".substr($url['path'],1);
error_log($text);
//$text="path: ".$url['path'];
//error_log($text);
$text="user: ".$url['user'];
error_log($text);
text="password: ".$url['pass'];
error_log($text);
$host=$url['host'];
$dbname=substr($url['path'],1);
$user=$url['user'];
$password=$url['pass'];

try {
    $pdo=new PDO("pgsql:host=$host;dbname=$dbname",$user,$password);
    if ($pdo==null) {
        error_log("Failed to connect to SQL");
    }
    $sql="select * from pg_user;";
    $stmt=$pdo->query($sql);
    $users=$stmt->fetchAll();
    print_r($users);
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>
