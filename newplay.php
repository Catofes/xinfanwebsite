<!DOCTYPE html>
<?$timea=microtime();?>
<html>
	<head>
		<title><? echo $_GET["name"]."	".$_GET["num"]."新番";?></title>
		<link href="dist/css/bootstrap.css" rel="stylesheet">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" value="IE=9">
		<link rel="stylesheet" href="css/base.css" />
<script type="text/javascript" src="/dist/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="abplayer/mobile.js"></script>
<script type="text/javascript" src="abplayer/CommentCore.js"></script>
<script type="text/javascript" src="abplayer/libxml.js"></script>
<script type="text/javascript" src="abplayer/Parsers.js"></script>
<script type="text/javascript" src="abplayer/player.js"></script>
<script type="text/javascript">
function avgo(){
	var avcode=document.getElementById("theavcode").value;
	var page=document.getElementById("thepage").value;
	if(avcode>0){
		if(page>0){
			getav(avcode,page);
		}else{
			getav(avcode,1);
		}
	}
}
function getvideoinfo(data){
	if(data.cid!=0){
		reload(data.cid);
	}
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
	if(window.abpinst.cmManager.display==true){
		window.abpinst.cmManager.display=false;
		window.abpinst.cmManager.clear();
		window.abpinst.cmManager.stopTimer();
	}
	CommentLoader("http://comment.bilibili.cn/"+cid+".xml",window.abpinst.cmManager);
	window.abpinst.cmManager.display = true;
	window.abpinst.cmManager.startTimer();
};
window.addEventListener("load",function(){
	var inst = ABP.bind(document.getElementById("player1"), isMobile());
	//CommentLoader("comment.xml", inst.cmManager);
	inst.cmManager.display = false;
	inst.cmManager.stopTimer();
	inst.txtText.focus();
	inst.txtText.addEventListener("keydown", function(e){
		if(e && e.keyCode === 13){
			if(/^!/.test(this.value)) return; //Leave the internal commands
			inst.txtText.value = "";
		}
	});
	window.abpinst = inst;
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
						<div class="col-xs-8 col-sm-6">
							<h3><? echo $_GET["name"]."  ".$_GET["num"];?></h3>
						</div>
						<div class="col-xs-4 col-sm-3">
							<div class="input-group">
								<input type="text" id="theavcode" class="form-control" placeholder="AVCode">
								<span class="input-group-btn">
									<input type="text" id="thepage" class="form-control" placeholder="Page">
									<button class="btn btn-default" type="button" onclick="avgo()">Go!</button>
								</span>
							</div>
						</div>
					</div>
				</div>
				<div id='htmlplayer' class="container" >
					<div id="player1" class="ABP-Unit" style="height:480px;" tabindex="1">
						<div class="ABP-Video">
							<div class="ABP-Container"></div>
							<video id="abp-video" autobuffer="true" data-setup="{}">
							<source src=<?php echo "/files/".rawurlencode($_GET["file"]);?> type="video/webm">
							<!-- // END VIDEO 1-->
							<!-- START VIDEO 2
							<source src="http://media.w3.org/2010/05/sintel/trailer.mp4" type="video/mp4">
							// END VIDEO 2-->
							<!-- START VIDEO 3
							<source src="http://content.bitsontherun.com/videos/bkaovAYt-52qL9xLP.mp4" type="video/mp4">
							<source src="http://content.bitsontherun.com/videos/bkaovAYt-27m5HpIu.webm" type="video/webm">
							// END VIDEO 3-->
							<p>Your browser does not support html5 video!</p>
							</video>

						</div>
						<div class="ABP-Text">
							<input type="text">
						</div>
						<div class="ABP-Control">
							<div class="button ABP-Play"></div>
							<div class="abpprogress-bar">
								<div class="bar dark"></div>
								<div class="bar"></div>
							</div>
							<div class="button ABP-CommentShow"></div>
							<div class="button ABP-FullScreen"></div>
						</div>
					</div>

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





