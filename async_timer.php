<?php
//swoole 间隔定时器．
swoole_timer_tick(1000,function($tickId,$params){
	echo "interval...";
	var_dump($params);
},array('wangyu','age'));