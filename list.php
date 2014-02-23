<?php
include("./config.php");
$timea=microtime();
$fanfile=fopen("fanlist.db","r");
$fan_list=unserialize(fread($fanfile,filesize("fanlist.db")));
fclose($fanfile);
function switchname($name,$fan_list)
{
	reset($fan_list);
	while(list($key,$val)=each($fan_list))
	{
		if(strpos($name,$val[2])!==false)return $val[1];
	}
	return $name;
}
function zhengze($filename,$wizhi,$tag,$cut_num)
{
	$linshi=explode($tag,$filename);
	return substr($linshi[$wizhi],$cut_num);
}
function fenge($file,$path)
{
	global $fan_list;
	if(is_dir($path.$file))
		return array("type"=>"folder","file"=>$file);
	$dot=explode(".",$file);
	if(end($dot)==="mp4")
	{   
		$linshi=explode("]",$file,4);
		if($linshi[1])return array("type"=>"mp4","name"=>substr($linshi[1],1),"num"=>substr($linshi[2],1),"zimu"=>substr($linshi[0],1),"cname"=>switchname(substr($linshi[1],1),$fan_list),"file"=>$file);
		else return array("type"=>"mp4","name"=>$linshi[0],"num"=>"unknow","zimu"=>"unknow","cname"=>$linshi[0],"file"=>$file);	
	}   
	else
	{   
		return array("type"=>"other","file"=>$file);
	}
}

function getlist($dir)
{	
	$linshi=array();
	$filelist=array();
	if(is_dir($dir)){
		if($dh=opendir($dir)){
			while (($file = readdir($dh)) !== false) {
				if ($file !="."&& $file!=".."){
					array_push($linshi,$file);
				}
			}
		}
		closedir($dh);
	}
	natcasesort($linshi);
	reset($linshi);
	while (list($key, $val) = each($linshi))
	{
		array_push($filelist,fenge($val,$dir));
	}
	return $filelist;				
}
function showfolder($filelist,$path="")
{
	while(list($key,$val) = each($filelist))
		if($val["type"]==="folder") 
			echo "Folder:   <a href=/list.php?path=".rawurlencode($path.$val["file"])."/>".$val["file"]."</a><br>";
}
function showmp4($filelist,$path=""){
	while (list($key, $val) = each($filelist))
	{
		if($val["type"]==="mp4")
		{
			echo "<a href=/play.php?file=".rawurlencode($path.$val["file"])."&name=".rawurlencode($val["cname"])."&num=".rawurlencode($val["num"]).">".$val["cname"]."  ".$val["name"]."    ".$val["num"]."</a> ";
			echo "<a href=/files/".rawurlencode($path.$val["file"]).">raw</a><br>";
		}
	}
}
function showother($filelist,$path=""){
	while (list($key, $val) = each($filelist))
	{
		if($val["type"]==="other") 
		{
			echo "Other:       <a href=/files/".rawurlencode($path.$val["file"]).">".$val["file"]."</a>";
			echo "&nbsp &nbsp <a href=/play.php?file=/".rawurlencode($path.$val["file"])."&name=".rawurlencode($val["cname"])."&num=".rawurlencode($val["num"]).">"."<s>Try to play it.</s></a><br>";
		}
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
		echo "This is not a folder.<br></body></html>";
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

$path=CheckDir($_GET);
$filelist=getlist($DIR.$path);
?>

<!DOCTYPE html>
<html>
	<head>
		<title>新番</title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">
		<link href="dist/css/bootstrap.css" rel="stylesheet">
		<link href="css/main.css" rel="stylesheet">
		<script type="text/javascript" src="/dist/jquery-1.10.2.min.js"></script>
		<script>
			$(function(){
			$("a").click(function(){
			var rel=$(this).attr("rel");
			var pos=$(rel).offset().top;//获取该点到头部的距离
			$("html,body").animate({scrollTop:pos-70}, 1000);
			})
			})
		</script>
	</head>
	<body>
		<div class="navbar navbar-inverse navbar-fixed-top">
			<div class="container">
				<div class="navbar-header">
					<button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a href="#" class="navbar-brand">新番</a>
				</div>
				<div class="navbar-collapse collapse">
					<ul class="nav navbar-nav">
						<li><a href="index.php">一月新番</a></li>
						<li class="active"><a href="">文件列表</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row row-offcanvas row-offcanvas-right">
				<div class="col-xs-12 col-sm-9">
					<p class="pull-right visible-xs">
						<button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">下拉菜单</button>
					</p>
				</div>
				<div class="jumbotron"style="padding-top:1px;padding-bottom:10px;">
					<h3>文件列表</h3>
				</div>
				<div class="cotainer">
<?
showfolder($filelist,$path);
showmp4($filelist,$path);
showother($filelist,$path);
?>
			</div>
		</div>
		<div class="footer">
			<div class="container">
				<p class="text-muted credit">
				Provide by
				<a href="about.php">Catofes</a>
				.Generate time:
				<? echo $timeb=microtime()-$timea;?>
				s  
				</p>
			</div>
		</div>
<script src="dist/js/bootstrap.min.js"></script>
</body>
	</html>


