<?php
$serv = new swoole_websocket_server('0.0.0.0',9501);
$serv->set([
	'daemonize'  => false,
	'worker_num' => 2
]);

$serv->on('start',function(swoole_websocket_server $serv){
	echo 'server start';
	swoole_set_process_name("swoole_websocket_server");
});

$serv->on("managerStart",function(swoole_websocket_server $serv){


});

$serv->on("managerStop",function(swoole_websocket_server $serv){

});
