<?php
$server = new swoole_server("127.0.0.1",8088);
echo posix_getpid();
$server->on("connect",function($serv,$fd){
	echo "hahah,client is connect";
});

$server->on('receive',function($serv,$fd,$form_id,$data){
	var_dump($fd);
	var_dump($form_id);
	echo "接受到客户端的数据是...",$data;
});

$server->on('close',function($serv,$fd){
	echo 'client close connection';
});
$server->start();
