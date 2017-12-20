<?php
function callbackFunc(swoole_process $process)
{
	$process->write("xxxx".$process->pid);
	echo "child process Form parent:".$recv;
	$process->exit(0);
}


$processArr = [];
for ($i=0; $i < 3; $i++) { 
	$process = new swoole_process('callbackFunc',false,true);
	$pid = $process->start();
	$processArr[$pid] = $process;
	sleep(3);
	//向队列中添加数据．
	$recv = $process->read();
	echo 'parent process...',$resv;
	$ret = swoole_process::wait();
	if($ret)
	{
		unset($processArr[$ret['pid']]);
	}
}

echo 'master process start!'.PHP_EOL;








