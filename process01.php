<?php
function test($worker)
{
	var_dump($worker);
}

$process = new swoole_process("test");
$process->start();
$pid = posix_getpid();
echo 'parent pid',$pid,
swoole_process::signal(SIGCHLD,function($sig){
	//回收子进程。有子进程退出的时候，返回数组，没有返回false.
	while($ret = swoole_process::wait(false)){
		//子进程的pid
		echo "child process pid,",$ret['pid'];
	}
});
