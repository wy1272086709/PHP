<?php
$workers = [];
$work_num = 3;

function doProcess(swoole_process $process)
{
	$process->write("PID:".$process->pid);
	echo "写入信息:".$process->pid.' '.$process->callback;
}

for ($i=0; $i < $work_num ; $i++) 
{ 
	$process = new swoole_process('doProcess');
	$pid = $process->start();
	$workers[$pid] = $process;
}
/*
foreach ($workers as $process) {
	swoole_event_add($process->pipe,function($pipe) use($process){
		$data = $process->read();
		echo "接受到:".$data.PHP_EOL;
	});
}*/