<?php

$url=parse_url(getenv('DATABASE_URL'));

print "host name:";
print $url['host'];
print "\n";
print "aaa";
//print(substr($url['path'],1));
//print($url['user']);
//print($url['pass']);
?>
