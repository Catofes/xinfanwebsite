<?$timea=microtime();?>
<?php
include("./config.php");
session_start();
if(!isset($_SESSION['cookie'])){
	header("Location:login.php");
	exit(0);
}
if($_COOKIE[$_SESSION['username']]!==$_SESSION['cookie'])
{
	echo "<html>
		<head>
		<meta http-equiv=\"refresh\" content=\"1;url=login.php\">
		<title>跳转中</title>	
		</head>
		</body>
		登录已过期，请重新登录。
		</body>
		</html>";
	exit(0);
}
$flexgetlogpath="/home/herbertqiao/.flexget/flexget.log";
$flexgetconfpath="/home/herbertqiao/.flexget/config.yml";
$flexgetconfnewname="/home/herbertqiao/.flexget/conf.bak/config.yml.back.".time();
$fanlistdb="fanlist.db";
$fanlistdbnewname="dbback/fanlist.db.back.".time();
if($_GET['action']==="saverss"){
	if($_POST){
		rename($flexgetconfpath,$flexgetconfnewname);
		$file=fopen($flexgetconfpath,'w');
		fwrite($file,$_POST['rssxml']);
		chmod($flexgetconfpath,0666);
		echo "<html>
			<head>
			<meta http-equiv=\"refresh\" content=\"1;url=admin.php?action=rssedit\">
			<title>跳转中</title>   
			</head>
			</body>
			保存完毕。
			</body>
			</html>";
		exit(0);
	}
	exit(0);
}
if($_GET['action']==="del"){
	$fanfile=fopen($fanlistdb,'r');
	$fan_list=unserialize(fread($fanfile,filesize($fanlistdb)));
	fclose($fanfile);
	rename($fanlistdb,$fanlistdbnewname);
	$fan_list_new=array();
	while(list($key,$val)=each($fan_list)){
		if($key!=$_GET['name'])
			array_push($fan_list_new,$val);
		else
			unlink("img/".$val[0].".jpg");
	}
	$fanfile=fopen($fanlistdb,'w');
	fwrite($fanfile,serialize($fan_list_new));
	fclose($fanfile);
	
	echo "<html>
		<head>
		<meta http-equiv=\"refresh\" content=\"1;url=admin.php?action=mainpageedit\">
		<title>跳转中</title>
		</head>
		</body>
		操作完毕。
		</body>
		</html>";
	exit(0);
}
function getImage($url,$save_dir='',$filename='',$type=0){
	if(trim($url)==''){
		return array('file_name'=>'','save_path'=>'','error'=>1);
	}
	if(trim($save_dir)==''){
		$save_dir='./';
	}
	if(trim($filename)==''){//保存文件名
		$ext=strrchr($url,'.');
		if($ext!='.gif'&&$ext!='.jpg'){
			return array('file_name'=>'','save_path'=>'','error'=>3);
		}
		$filename=time().$ext;
	}
	if(0!==strrpos($save_dir,'/')){
		$save_dir.='/';
	}
	//创建保存目录
	if(!file_exists($save_dir)&&!mkdir($save_dir,0777,true)){
		return array('file_name'=>'','save_path'=>'','error'=>5);
	}
	//获取远程文件所采用的方法 
	if($type){
		$ch=curl_init();
		$timeout=30;
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
		$img=curl_exec($ch);
		curl_close($ch);
	}else{
		ob_start(); 
		readfile($url);
		$img=ob_get_contents(); 
		ob_end_clean(); 
	}
	$size=strlen($img);
	//文件大小 
	$fp2=fopen($save_dir.$filename,'wb');
	fwrite($fp2,$img);
	fclose($fp2);
	unset($img,$url);
	return array('file_name'=>$filename,'save_path'=>$save_dir.$filename,'error'=>0,'size'=>$size);
}
if($_GET['action']==="add"){
	if($_POST){
		$fanfile=fopen($fanlistdb,'r');
		$fan_list=unserialize(fread($fanfile,filesize($fanlistdb)));
		fclose($fanfile);
		rename($fanlistdb,$fanlistdbnewname);
		array_push($fan_list,[$_POST['bianhao'],$_POST['cname'],$_POST['shibie']]);
		$fanfile=fopen($fanlistdb,'w');
		fwrite($fanfile,serialize($fan_list));
		fclose($fanfile);
		if($_POST['url'])
			print_r(getImage($_POST['url'],'img',$_POST['bianhao'].'.jpg'));
		echo "<html>
			<head>
			<meta http-equiv=\"refresh\" content=\"1;url=admin.php?action=mainpageedit\">
			<title>跳转中</title>
			</head>
			</body>
			操作完毕。
			</body>
			</html>";
		exit(0);
	}
	exit(0);
}
function ShowControlBar($name)
{
	echo "<ul class=\"nav nav-pills nav-justified\">";
	if($name===1)echo "<li class=\"active\"><a href=\"admin.php?action=flexgetlog\">FlexgetLog</a></li>";
	else echo "<li><a href=\"admin.php?action=flexgetlog\">FlexgetLog</a></li>";
	if($name===2)echo "<li class=\"active\"><a href=\"admin.php?action=rssedit\">RSSEdit</a></li>";
	else echo "<li><a href=\"admin.php?action=rssedit\">RSSEdit</a></li>";
	if($name===3)echo "<li class=\"active\"><a href=\"admin.php?action=mainpageedit\">MainPageEdit</a></li>";
	else echo "<li><a href=\"admin.php?action=mainpageedit\">MainPageEdit</a></li>";
	if($name===4)echo "<li class=\"active\"><a href=\"admin.php?action=upload\">yaaw</a></li>";
	else echo "<li><a href=\"yaaw.php\">yaaw</a></li>";
	echo "</ul>";
}
function ShowFlexgetLog($k)
{
	global $flexgetlogpath;
	echo "<br>
		<div class=\"panel panel-info\">
		<div class=\"panel-heading\">FlexgetLog</div>
		<div class=\"panel-body\">
		";
	$file=fopen($flexgetlogpath,'r');
	fseek($file,-1,SEEK_END);
	$res=array();
	$t='';
	while($k){
		$ch=fgetc($file);
		if($ch===false)break;
		switch($ch){
		case "\n":
		case "\r":
			if($t){
				array_push($res,$t);
				$k--;
			}
			$t='';
			break;
		default:
			$t=$ch.$t;
		}
		fseek($file,-2,SEEK_CUR);
	}
	fclose($file);
	reset($res);
	while(list($key,$val)=each($res))
		echo htmlspecialchars($val)."<br>";
	echo "</div></div>";
}
function ShowRSSEdit(){
	global $flexgetconfpath;
	echo "<br>
		<div class=\"panel panel-info\">
		<div class=\"panel-heading\">RSSEdit</div>
		<div class=\"panel-body\">
		";
	$file=fopen($flexgetconfpath,'r');
	echo "<div class=\"container\"><form method=\"post\" action=\"admin.php?action=saverss\" onSubmit=\"return this\"><textarea id=\"rssxml\" name=\"rssxml\" style=\"width:100%;height:500px\">";
	echo fread($file,1000000);
	echo "</textarea><br><div style=\"margin-top:10px;\"><button class=\"btn btn-lg btn-primary btn-block\" type=\"submit\">保存</button></div></form></div>";
	echo "</div></div>";
	fclose($file);
}
function ShowMainPageEdit()
{
	global $fanlistdb;
	$fanfile=fopen($fanlistdb,'r');
	$fan_list=unserialize(fread($fanfile,filesize($fanlistdb)));
	fclose($fanfile);
	echo "<br>
		<div class=\"panel panel-info\">
		<div class=\"panel-heading\">MainPageEdit</div>
		<div class=\"panel-body\">
		<table class=\"table\">
		<tr>
		<td>编号名</td>
		<td>中文名</td>
		<td>检索字符</td>
		<td>编辑</td>
		</tr>
		";
	while(list($key,$val)=each($fan_list))
	{
		echo "<tr><td>".$val[0]."</td><td>".$val[1]."</td><td>".$val[2]."</td><td><a href=\"admin.php?action=del&&name=".$key."\">删除</a></td></tr>";
	}
	echo "
		<form method=\"post\" action=\"admin.php?action=add\" onSubmit=\"return this\">
		<tr>
		<td><input type=\"text\" name=\"bianhao\"class=\"form-control\" placeholder=\"编号\"></td>
		<td><input type=\"text\" name=\"cname\"class=\"form-control\" placeholder=\"中文名\"></td>
		<td><input type=\"text\" name=\"shibie\"class=\"form-control\" placeholder=\"区分字符段\"></td>
		<td></td>
		</tr>
		<tr>
		<td colspan=\"3\"><input type=\"text\" name=\"url\"class=\"form-control\"placeholder=\"图片下载地址\"></td>
		<td><button class=\"btn btn-primary btn-block\" type=\"submit\">添加</button></td>
		</tr>
		</form>
		";
	echo "</table>";
	echo "</div></div></div>";

}
function ShowContent($GET)
{
	switch ($GET['action'])
	{
	case "mainpageedit":
		ShowControlBar(3);
		ShowMainPageEdit();
		break;
	case "rssedit":
		ShowControlBar(2);
		ShowRSSEdit();
		break;
	default:
	case "flexgetlog":
		ShowControlBar(1);
		ShowFlexgetLog(50);
		break;	
}
}
?>
	<!DOCTYPE html>
	<html>
	<head>
	<title>管理 新番</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<link href="dist/css/bootstrap.css" rel="stylesheet">
	<link href="css/admin.css" rel="stylesheet">
	<link href="css/yaaw.css" rel="stylesheet" />
	<script type="text/javascript" src="/dist/jquery-1.10.2.min.js"></script>
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
						<li><a href="index.php">四月新番</a></li>
						<li><a href="list.php">文件列表</a></li>
						<li><a href="admin.php">管理</a></li>
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
			</div>
			<div class="jumbotron" style="padding-top:1px;padding-bottom:10px;">
				<h3>管理</h3>
			</div>
		</div>
		<div class="container" id="control">
			<? ShowContent($_GET);?>
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


