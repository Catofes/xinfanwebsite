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
function getlist($DIR)
{	
	$filelist=array();
	if(is_dir($DIR)){
		if($dh=opendir($DIR)){
			while (($file = readdir($dh)) !== false) {
				if (!is_dir($DIR.$file)){
					array_push($filelist,$file);
				}
			}
		}
		closedir($dh);
	}
	natcasesort($filelist);
	return $filelist;				
}
$filelist=getlist($DIR);
?>




<!DOCTYPE html>
<html>
	<head>
		<title>北大</title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">
		<link href="dist/css/bootstrap.css" rel="stylesheet">
		<link href="css/main.css" rel="stylesheet">
		<script type="text/javascript" src="/dist/jquery-1.10.2.min.js"></script>
		<script>
			$(function(){$("a").click(function(){
			var rel=$(this).attr("rel");
			var pos=$(rel).offset().top;//获取该点到头部的距离
			$("html,body").animate({scrollTop:pos-70},{duration:1000,queue:false});
			var idocheight=$(document.body).height();
			var isidheight=$("#sidebar").height();
			var iwinheight=$(window).height();
			var ioffsetTop=(pos-70)*(idocheight-isidheight)/(idocheight-iwinheight)*0.988+"px";
			$("#sidebar").animate({top:ioffsetTop},{duration:1000,queue:false ,complete:function(){$.setscrool();}});
			$(window).unbind("scroll");
			})
			})
			$.extend({
				setscrool:function(){
				$(window).scroll(function(){
					if($(window).width()>768){
						$("#sidebar").css("display","inline");
						var sidheight=$("#sidebar").height();
						var thetop=$(window).scrollTop();
						var docheight=$(document.body).height();
						var winheight=$(window).height();
						var offsetTop=thetop*(docheight-sidheight)/(docheight-winheight)*0.988+"px";
						$("#sidebar").animate({top:offsetTop},{ duration:200 , queue:false });
					}else{
						$("#sidebar").css("display","none");
					}
				})
				}});
			$.setscrool();
		</script>
	</head>
	<body>
		<div class="navbar navbar-inverse navbar-fixed-top">
			<div class="container"onclick=$("html,body").animate({scrollTop:0},1000);>
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
						<li class="active">
						<a href="">一月新番</a>
						</li>
						<li>
						<a href="list.php">文件列表</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="container" id="top1">
			<div class="row row-offcanvas row-offcanvas-right">
				<div class="col-xs-12 col-sm-9">
					<p class="pull-right visible-xs">
					<button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">下拉菜单</button>
					</p>
					<div class="jumbotron">
						<h1>一月新番</h1>
					</div>
					<div class="row">
<?php
reset($fan_list);
while (list($key, $val) = each($fan_list))
{
	$linshi=array();
	echo				"<div class=\"panel panel-default\">
							<div class=\"panel-heading\"id=\"".$val[0]."\">
								<h3 class=\"panel-title\">".$val[1]."</h3>
							</div>
							<div class=\"panel-body\">
								<img data-src=\"holder.js\" src=\"img/".$val[0].".jpg\" class=\"img-thumbnail\">";
//	echo						"<ul class=\"pagination\">";
	reset($filelist);
	while (list($key_1,$val_1)=each($filelist))
		if(switchname($val_1,$fan_list)===$val[1])
			array_push($linshi,$val_1);
	if($linshi){
		$name=zhengze($linshi[0],1,$TAG,$CUT_NUM);
		$zimuzu=zhengze($linshi[0],0,$TAG,$CUT_NUM);
		echo						"<h4>".$name."	[".$zimuzu."]</h4><ul class=\"pagination\">";
		reset($linshi);
		while (list($key_2,$val_2)=each($linshi))
			if(zhengze($val_2,1,$TAG,$CUT_NUM)===$name)
				echo					"<li><a href=\"play.php?file=".rawurlencode($val_2)."&name=".rawurlencode($val[1])."&num=".zhengze($val_2,2,$TAG,$CUT_NUM)."\">".zhengze($val_2,2,$TAG,$CUT_NUM)."</a></li>";
			else{
				$name=zhengze($val_2,1,$TAG,$CUT_NUM);
				echo				"</ul><h4>".$name."	[".$zimuzu."]</h4><ul class=\"pagination\"><li><a href=\"play.php?file=".rawurlencode($val_2)."&name=".rawurlencode($val[1])."&num=".zhengze($val_2,2,$TAG,$CUT_NUM)."\">".zhengze($val_2,2,$TAG,$CUT_NUM)."</a></li>";
			}
		}	
	echo						"</ul>
							</div>
						</div>";
}
?>
					</div>
				</div>
				<div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">
					<div class="list-group">
<?php
reset($fan_list);
while (list($key, $val) = each($fan_list))
	echo				"<a rel=#".$val[0]." class=\"list-group-item\">".$val[1]."</a>";?>
					</div>
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


