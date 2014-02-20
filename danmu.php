<?php
$App_Key="0d71ee974da02724";
$App_Secret="e3f9d09e31acc04b766b1456e54af408";

function get_sign($params, $key) {
	$_data = array();
	ksort($params);
	reset($params);
	foreach ($params as $k => $v) {
		// rawurlencode 返回的转义数字必须为大写( 如%2F )
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

if($_GET['f']=='gav'){
	if($_GET['page']>1)
		print geturl_av($_GET['av'],$_GET['page']);
	else print geturl_av($_GET['av']);
	exit;
}

?>
