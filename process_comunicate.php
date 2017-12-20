<?php

$server = new swoole_server('127.0.0.1',8088);

//配置运行时候的配置．
$server->set([
	'worker_num' => 4,
	'task_worker_num' => 4,
	'reactor_num'=> 2,
	'max_request' => 50,
	'daemonize' => true,
	'log_file'    => '/tmp/swoole.log'	
]);

//发送数据的时候，需要fd,$from 来自于哪个
$server->on("connect",function(swoole_server $serv,$fd,$from_id){
	//连接的时候，
	$serv->send($fd,"发送数据到客户端,from".$from_id.PHP_EOL);
});

$server->on('pipeMessage',function($server,$from_worker_id,$message){
	echo "pipe message event is start".PHP_EOL;
	echo "from worker id is ",$from_worker_id.PHP_EOL;
	echo $message.PHP_EOL;
});

//接受到数据的时候，投递任务到worker 进程池中.
//接受到客户端的数据的时候，回调此函数。发生在worker 进程中.
$server->on('receive',function($server,$fd,$from_id,$data){
	echo 'receive data from client'.$data.PHP_EOL;
	echo '投递异步任务到task worker池中'.PHP_EOL;
	$taskId = $server->task($data);
	//可以在worker和管理进程中触发.
	//向任意的worker 或者task 进程发送消息.(表现了worker 之间的通信)
	$server->sendMessage("hello ,message!",3);
});

$server->on('close',function(){
	echo 'client is close';
});

//task worker 进程被调用.
//$task_id 任务id,
//$from_id 来自于哪个worker
//$data 是任务内容.
$server->on('task',function(swoole_server $serv,$task_id,$from_id,$data){
	echo 'task_id is ...'.PHP_EOL;
	var_dump($task_id);
	echo 'from_id is ...'.PHP_EOL;
	var_dump($from_id);
	echo 'data is ...'.PHP_EOL;
	var_dump($data);
	echo 'task event is triggered'.PHP_EOL;
	//表示task worker 已经处理完了任务。
	//finish 后面可以接访问的结果的字符串.
	$serv->finish("response");
	//这里会调用两次.
	return "hehe";
});

$server->on('finish',function($serv,$taskId,$data){
	echo 'task id is '.$taskId.PHP_EOL;
	echo 'data is '.$data.PHP_EOL;
});

$server->on('workerStart',function($serv,$workerId){
	//根据worker id 判断是普通worker ，还是task worker.
	$num = $serv->setting['worker_num'];
	echo 'worker num is ',$num,PHP_EOL;
	if ($num>$workerId) 
	{
		echo 'this is a task woker';
	}
	else
	{
		echo 'this is a common worker';
	}
	echo 'worker start!'.PHP_EOL;
});

$server->on('workerStop',function(){
	echo 'worker stop!'.PHP_EOL;
});

$server->on('managerStart',function(){
	echo 'manager start!'.PHP_EOL;
});

$server->on('managerStop',function(){
	echo 'manger stop'.PHP_EOL;
});

$server->on('start',function(){
	echo 'start'.PHP_EOL;
});

$server->start();
$server->reload();
?>