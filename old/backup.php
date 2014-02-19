<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
</head>
<body>
<?php   
$dir = "/home/drive/xinfan/files/";
function myswitch($name){
	if(strpos($name,'onogatari')!='')return "物语系列";
	if(strpos($name,'Unbreakable')!='')return "机巧少女不会受伤";
	if(strpos($name,'onnonbiyor')!='')return "悠哉日常大王";
	if(strpos($name,'Outbreak')!='')return "萌萌侵略者";
	if(strpos($name,'yousougiga')!='')return "京骚戏话";
	if(strpos($name,'Asukara')!='')return "来自风平浪静的明天";
	if(strpos($name,'Infinite')!='')return "IS2";
	if(strpos($name,'LittleBusters')!='')return "Little Busters~Refrain~";
	if(strpos($name,'yokai')!='')return "境界的彼方";
	if(strpos($name,'Arpeggio')!='')return "苍蓝钢铁战舰";
	if(strpos($name,'Walroma')!='')return "少女骑士物语";
	if(strpos($name,'GoldenTime')!='')return "Golden Time";
	if(strpos($name,'COPPE')!='')return "核爆默示录";
	if(strpos($name,'WHITE')!='')return "白色相簿2";
	if(strpos($name,'galilei')!='')return "伽利略少女";
	if(strpos($name,'Noucome')!='')return "我的脑内恋碍选项";
	if(strpos($name,'Tsuyoku')!='')return "想成为世界最强";
	return $name;
}
function zhengze($file){
	$linshi=explode("]",$file,4);
	return array("name"=>substr($linshi[1],1),"num"=>substr($linshi[2],1),"zimu"=>substr($linshi[0],1),"cname"=>myswitch($linshi[1]),"file"=>$file);
}
function mylist($dir){
	$linshi1=array();
	$filelist=array();   
	if (is_dir($dir)) {   
		if ($dh = opendir($dir))    
			while (($file = readdir($dh)) !== false) {   
				if ($file!="." && $file!="..") {
					array_push($linshi1,$file);   
#echo "<a href=/play.php?file=".rawurlencode($file).">".zhengze($file)["cname"]."</a><br>";   
				}   
			}   
		closedir($dh);   
	}
	natcasesort($linshi1);
	reset($linshi1);
	while (list($key, $val) = each($linshi1))
	{
		echo "<a href=/play.php?file=".rawurlencode($val).">".zhengze($val)["cname"]."	".zhengze($val)["name"]."	".zhengze($val)["num"]."</a>		<a href=/files/".rawurlencode($val).">raw</a><br>"; 
		array_push($filelist,zhengze($val));
	}	
	return $filelist;   
}
$filelist=mylist($dir);
#print_r($filelist);
?> 
</body>
