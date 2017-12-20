<?php
$http = new swoole_http_server('127.0.0.1',9501);
$http->on('request',function($req,$resp){
	$name = $req->post['name'];
	$age  = $req->post['age'];
	$resp->end("<h1> Hi,".$name.",I am $age 岁"." welcome to you!</h1>");
});

$http->start();

?>