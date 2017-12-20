<?php
function runner(swoole_process $sub_process)
{
    swoole_timer_tick(1000, function(){
        echo "Hello World";
    });
}
$process = new swoole_process("runner", false, 1);
$pid = $process->start();
