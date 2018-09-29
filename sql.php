<?php

$url=parse_url(getenv('DATABASE_URL'));

$text="host name: ".$url['host']."\n";
print $text;
print "aaa";
//print(substr($url['path'],1));
//print($url['user']);
//print($url['pass']);
?>
