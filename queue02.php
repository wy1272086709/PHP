<?php
/**
 * @param swoole_process $sub_process
 */
function runner(swoole_process $sub_process)
{
    echo $sub_process->pop(),'i from child'."\n";
    $sub_process->push("Hello Main Process");
    $sub_process->exit(0);
}
//使用模式１，使用指定的子进程推送消息，就会在指定的子进程收到．

$process = new swoole_process("runner", false, 1);
// 使用模式1,1
$process->useQueue(ftok(__FILE__, 'p'), 1);
$process->start();

$process->push("Hello Sub Process");
// 防止消息被父进程自己消费
sleep(1);   
echo $process->pop(),' I from parent'."\n";
swoole_process::wait(true);

?>