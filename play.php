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
		<script src="/videojsABdm/CommentCoreLibrary.js"></script>
		<script src="/videojsABdm/BilibiliFormat.js"></script>
		<link href="/video-js/video-js.css" rel="stylesheet">
		<script src="/video-js/video.js"></script>
		<link href="/videojsABdm/videojs_ABdm.css" rel="stylesheet">
		<script src="/videojsABdm/videojs_ABdm.js"></script>
		<script src="play.js"></script>
<script type="text/javascript">
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
					<li><a href="index.php">新番</a></li>
					<li><a href="list.php">文件列表</a></li>
					<li><a href="localplay.php">本地播放</a><li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li><a onclick="setting()" >设置</a></li>
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
	</div>
	<div class="container" id="setting" style="height:0px;overflow:hidden">
		<div class="jumbotron" style="height:70px;padding-top:5px;padding-bottom:10px;">
			<div class="col-md-6">
				<form class="form-inline" role="form">
					<div class="form-group">
						<label class="sr-only" for="exampleInputEmail2">AVCode</label>
						<input type="text" class="form-control" id="changetitle" placeholder="更改名称">
					</div>
					<button type="button" class="btn btn-default" onclick="changeTitle()">Go!</button>
				</form>
			</div>
			<div class="col-md-6">
				<input type="file" id="file" data-filename-placement="inside" title="选择本地文件" onchange="onInputFileChange()">  
			</div>
		</div>
	</div>
	<div class="container">
		<div class="jumbotron" style="padding-top:5px;padding-bottom:10px;">
			<b style="margin-top:1px" id="filetitle"><? echo $_GET["name"]."  ".$_GET["num"];?></b>
			<form class="form-inline" role="form" style="float:right">
				<div class="form-group">
					<label class="sr-only" for="exampleInputEmail2">AVCode</label>
					<input type="text" class="form-control" id="theavcode" placeholder="AVCode">
				</div>
				<div class="form-group">
					<label class="sr-only" for="exampleInputPassword2">Page</label>
					<input type="text" class="form-control" id="thepage" placeholder="Page">
				</div>
				<button type="button" class="btn btn-default" onclick="avgo()">Go!</button>
			</form>
			<p id="status" class="text-muted credit" style="float:right;margin-top:11px"></p>
			<br>
			<a href="#" style="font-size:16px" id=bilibili>弹幕地址：未载入</a>
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
<script src="/dist/jquery-1.7.1.min.js"></script>
<script src="dist/js/bootstrap.min.js"></script>
<script src="dist/bootstrap.file-input.js"></script>
<script>
$('input[type=file]').bootstrapFileInput();
</script>
</body>
	</html>


