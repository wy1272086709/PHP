<?php
//文件存在返回true,不存在返回false.
//不适合读取太大的文件
//当文件不存在的时候，会报错.
$isExists = swoole_async_readfile(__DIR__."/1.json",
function($fileName,$content){
	echo "$fileName:$content";
});

var_dump($isExists);
