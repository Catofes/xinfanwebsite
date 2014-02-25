<?$timea=microtime();
	header('Access-Control-Allow-Origin: * ');
	header('Access-Control-Allow-Methods:POST,GET');
	header('Access-Control-Allow-Credentials:true');
?>
<!DOCTYPE html>
<html>
	<head>
		<title><? echo $_GET["name"]."	".$_GET["num"]."新番";?></title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">
		<link href="dist/css/bootstrap.css" rel="stylesheet">
<script type="text/javascript" src="/dist/jquery-1.10.2.min.js"></script>
<script src="/videojsABdm/CommentCore.js"></script>
<script src="/videojsABdm/Parsers.js"></script>
<link href="/video-js/video-js.css" rel="stylesheet">
	<script src="/video-js/video.js"></script>
<link href="/videojsABdm/videojs_ABdm.css" rel="stylesheet">
	<script src="/videojsABdm/videojs_ABdm.js"></script>
<script type="text/javascript">
function avgo(){
	var avcode=document.getElementById("theavcode").value;
	var page=document.getElementById("thepage").value;
	if(avcode>0){
		document.getElementById("status").textContent="弹幕载入中";
		if(page>0){
			getav(avcode,page);
		}else{
			getav(avcode,1);
		}
	}
}
function getfinish(st){
	if(st==true){
		document.getElementById("status").textContent="弹幕载入完毕";
	}
	else{
		document.getElementById("status").textContent="弹幕载入失败";
	}
}
function getvideoinfo(data){
	if(data.cid!=0){
		reload(data.cid);
	}else
		getfinish(false);
};
function getav(av,page){
	var xmlhttp;
	var xmlhttp1;
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}

	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			//document.getElementById("myDiv").innerHTML=xmlhttp.responseText;
			var url=xmlhttp.responseText+"&callback=getvideoinfo";
			var script=document.createElement('script');
			script.setAttribute('src', url);
			document.getElementsByTagName('head')[0].appendChild(script); 
		}
	}
	xmlhttp.open("GET","/danmu.php?f=gav&av="+av+'&page='+page,true);
	xmlhttp.send();
};
function reload(cid){
	if(window.thevideojs.cmManager.display==true){
		window.thevideojs.cmManager.display=false;
		window.thevideojs.cmManager.clear();
		window.thevideojs.cmManager.stopTimer();
	}
	window.thevideojs.CommentLoader("http://comment.bilibili.cn/"+cid+".xml",getfinish);
	window.thevideojs.cmManager.display = true;
	window.thevideojs.cmManager.startTimer();
};
window.addEventListener("load",function(){
	window.thevideojs = videojs("example_video_1");
	thevideojs.ABP();
});
</script>
</head>
<body>
	<div class="navbar navbar-inverse navbar-static-top">
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
					<li><a href="list.php">文件列表</a></li>
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
			<div class="jumbotron" style="padding-top:1px;padding-bottom:10px;">
				<div class="row">
					<div class="col-xs-8">
						<h3><? echo $_GET["name"]."  ".$_GET["num"];?></h3>
					</div>
					<div class="col-xs-4">
						<div style="float:right;margin-top:auto;width:150px">
							<div class="input-group" style="float:right">
								<input type="text" id="theavcode" class="form-control" placeholder="AVCode">
								<input type="text" id="thepage" class="form-control" placeholder="Page">
								<span class="input-group-btn">
									<button class="btn btn-default" type="button" onclick="avgo()">Go!</button>
								</span>
							</div>
						</div>
						<h3 id="status" class="text-muted credit" style="float:rght"></h3>
					</div>
				</div>
			</div>
			<div class="container" style="border-left:auto; border-right:auto;">
				<video id="example_video_1" class="video-js vjs-default-skin"
				controls preload="auto"width="auto" height="480"
				data-setup='{"example_option":true}'>
				<source src=<?php echo "/files/".rawurlencode($_GET["file"]);?> type='video/mp4' />

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


