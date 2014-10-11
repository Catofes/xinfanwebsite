<?php
$App_Key="0d71ee974da02724";
$App_Secret="e3f9d09e31acc04b766b1456e54af408";

function get_sign($params, $key) {
	$_data = array();
	ksort($params);
	reset($params);
	foreach ($params as $k => $v) {
		$_data[] = $k . '=' . rawurlencode($v);
	}
	$_sign = implode('&', $_data);
	return array(
		'sign' => strtolower(md5($_sign.$key)),
		'params' => $_sign,
	);
}

function geturl_av($av,$page=1) {
	global $App_Key;
	global $App_Secret;
	$params=['type'=>'jsonp','appkey'=>$App_Key,'id'=>$av,'page'=>$page];
	$params=get_sign($params,$App_Secret);
	return "http://api.bilibili.cn/view?".$params['params']."&sign=".$params['sign'];
}

function search($name,$num='',$page=1) {
	global $App_Key;
	global $App_Secret;
	if($_GET['xf']=="true")
		$params=['type'=>'jsonp','appkey'=>$App_Key,'pagesize'=>1,'page'=>$page,'keyword'=>$name." ".$num." @新番"];
	else
		$params=['type'=>'jsonp','appkey'=>$App_Key,'pagesize'=>1,'page'=>$page,'keyword'=>$name." ".$num];
	$params=get_sign($params,$App_Secret);
	return "http://api.bilibili.cn/search?".$params['params']."&sign=".$params['sign'];
}

function spview($id) {
	global $App_Key;
	global $App_Secret;
	$params=['type'=>'jsonp','appkey'=>$App_Key,'spid'=>$id];
	$params=get_sign($params,$App_Secret);
	return "http://api.bilibili.cn/spview?".$params['params']."&sign=".$params['sign'];
}

function spsearch($name) {
	global $App_Key;
	global $App_Secret;
	$params=['type'=>'jsonp','appkey'=>$App_Key,'title'=>$name];
	$params=get_sign($params,$App_Secret);
	return "http://api.bilibili.cn/sp?".$params['params']."&sign=".$params['sign'];
}

function ban($id) {
	global $App_Key;
	global $App_Secret;
	$params=['type'=>'jsonp','appkey'=>$App_Key,'spid'=>$id];
	$params=get_sign($params,$App_Secret);
	return "http://api.bilibili.cn/bangumi?".$params['params']."&sign=".$params['sign'];
}


if($_GET['f']=='gav'){
	if($_GET['page']>1)
		print geturl_av($_GET['av'],$_GET['page']);
	else print geturl_av($_GET['av']);
	exit;
}

if($_GET['f']=='search'){
	if(!$_GET['num'])
		print search($_GET['name'],'',$_GET['page']);
	else print search($_GET['name'],$_GET['num'],$_GET['page']);
	exit;
}

if($_GET['f']=='spv'){
	print spview($_GET['id']);
	exit;
}

if($_GET['f']=='sps'){
	print spsearch($_GET['name']);
	exit;
}
if($_GET['f']=='b'){
	print ban($_GET['id']);
	exit;
}
?>
