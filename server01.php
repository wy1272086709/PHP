<?php

$http = new swoole_http_server('127.0.0.1',9501);
$http->on('request',function($req,$resp){
	$resp->end("<h1>Hello world!</h1>");
});

$http->start();