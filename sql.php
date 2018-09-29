<?php

$url=parse_url(getenv('DATABASE_URL'));

$text="host name: ".$url['host'];
error_log($text);
$text="path: ".substr($url['path'],1);
error_log($text);
$text="user: ".$url['user'];
error_log($text);
$text="password: ".$url['pass'];
error_log($text);
?>
