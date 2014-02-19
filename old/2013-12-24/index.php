<?php $timea=microtime()?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<title>北大新番</title>
</head>
<body>
<?php   
$DIR = "/home/drive/xinfan/files/";
function myswitch($name){
	if(strpos($name,'onogatari')!==false)return "物语系列";
	if(strpos($name,'Unbreakable')!==false)return "机巧少女不会受伤";
	if(strpos($name,'onnonbiyor')!==false)return "悠哉日常大王";
	if(strpos($name,'Outbreak')!==false)return "萌萌侵略者";
	if(strpos($name,'yousougiga')!==false)return "京骚戏话";
	if(strpos($name,'Asukara')!==false)return "来自风平浪静的明天";
	if(strpos($name,'Infinite')!==false)return "IS2";
	if(strpos($name,'LittleBusters')!==false)return "Little Busters~Refrain~";
	if(strpos($name,'yokai')!==false)return "境界的彼方";
	if(strpos($name,'Arpeggio')!==false)return "苍蓝钢铁战舰";
	if(strpos($name,'Walroma')!==false)return "少女骑士物语";
	if(strpos($name,'GoldenTime')!==false)return "Golden Time";
	if(strpos($name,'COPPE')!==false)return "核爆默示录";
	if(strpos($name,'WHITE')!==false)return "白色相簿2";
	if(strpos($name,'galilei')!==false)return "伽利略少女";
	if(strpos($name,'Noucome')!==false)return "我的脑内恋碍选项";
	if(strpos($name,'Tsuyoku')!==false)return "想成为世界最强";
	return $name;
}

function zhengze($file,$path){
	if(is_dir($path.$file)){
		return array("type"=>"floder","file"=>$file);
	}
	$dot=explode(".",$file);
	if(end($dot)==="mp4")
	{
		$linshi=explode("]",$file,4);
		return array("type"=>"mp4","name"=>substr($linshi[1],1),"num"=>substr($linshi[2],1),"zimu"=>substr($linshi[0],1),"cname"=>myswitch(substr($linshi[1],1)),"file"=>$file);
	}	
	else
	{
		return array("type"=>"other","file"=>$file);

	}
}

function mylist($dir){
	$linshi1=array();
	$filelist=array();   
	if (is_dir($dir)) {   
		if ($dh = opendir($dir))
			while (($file = readdir($dh)) !== false) {
				if ($file!="." && $file!="..") {
					array_push($linshi1,$file);   
				}   
			}   
		closedir($dh);   
	}
	natcasesort($linshi1);
	reset($linshi1);
	while (list($key, $val) = each($linshi1))
	{
		array_push($filelist,zhengze($val,$dir));
	}	
	return $filelist;   
}
function showfloder($filelist,$path=""){
	while (list($key, $val) = each($filelist))
	{
		if($val["type"]==="floder") echo "Floder:	<a href=/index.php?path=".rawurlencode($path.$val["file"])."/>".$val["file"]."</a><br>";
	}
}
function showmp4($filelist,$path=""){
	while (list($key, $val) = each($filelist))
	{
		if($val["type"]==="mp4")
		{
			echo "<a href=/play.php?file=".rawurlencode($path.$val["file"])."&name=".rawurlencode($val["cname"])."&num=".rawurlencode($val["num"]).">".$val["cname"]."	".$val["name"]."	".$val["num"]."</a>	";
			echo "<a href=/files/".rawurlencode($path.$val["file"]).">raw</a><br>";
		}
	}
}

function showother($filelist,$path=""){
	while (list($key, $val) = each($filelist))
	{
		if($val["type"]==="other") echo "Other:       <a href=/files/".rawurlencode($path.$val["file"]).">".$val["file"]."</a><br>";
	}
}

function CheckDir($post)
{
	global $DIR;
	$linpath="";
	if(array_key_exists("path",$post))$linpath=$post["path"];
	$path=explode("..",$linpath)[0];
	if(!is_dir($DIR.$path))
	{
		echo "This is not a floder.<br></body></html>";
		exit();
	}
	chdir($DIR.$path);
	if(strpos(getcwd()."/",$DIR)===false)
	{
		echo "Path Illegal.<br></body></html>";
		exit();
	}
	return $path;
}
/** Show the Table 
=================================
**/
$path=CheckDir($_GET);
$filelist=mylist($DIR.$path);
showfloder($filelist,$path);
showmp4($filelist,$path);
showother($filelist,$path);
$timeb=microtime()-$timea;
echo "Generate Time:";
printf("%f",$timeb);
echo "us.<br></body></html>";
?> 
</body>
