<?php
$ch = curl_init();
$url = 'http://localhost:9501/';
$data = [
	'name' => 'wangyu',
	'age'  => 35
];
curl_setopt($ch, CURLOPT_URL,$url );
curl_setopt($ch, CURLOPT_POST,1 );
curl_setopt($ch, CURLOPT_POSTFIELDS,$data );
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1 );
$postRe = curl_exec($ch);
var_dump($postRe);
curl_close($ch);
?>