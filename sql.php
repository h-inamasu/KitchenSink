<?php

$url=parse_url(getenv('DATABASE_URL'));

$host=$url['host'];
$dbname=substr($url['path'],1);
$user=$url['user'];
$password=$url['pass'];
error_log("host: ".$host);
error_log("dbname: ".$dbname);
error_log("user: ".$user);
error_log("password: ".$password);

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
