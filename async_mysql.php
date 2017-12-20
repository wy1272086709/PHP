<?php
$db = new swoole_mysql;
$server = array(
	'host' => '127.0.0.1',
	'port' => 3306,
	'user' => 'root',
	'password' => '123456',
	'database' => 'immoc_shop',
	'charset'  => 'utf8',
	'timeout'  => 2,//可选，连接超时时间．
);

$db->connect($server,function($db,$r){
	if($r===false)
	{
		var_dump($db->connect_errno,$db->connect_error);
		die;
	}

	$sql = "select * from imooc_shop.shop_admin";
	//执行失败，result 为false,
	//执行成功，sql 为非查询语句，$result为true,
	//读取$link 对象的affected_rows 属性获得影响的行数，
	//insert_id 属性获得insert 操作的自增id
	//查询成功，sql为查询语句，$result 为结果数组．
	$db->query($sql,function($link,$result){
		var_dump($result);
	});
});

