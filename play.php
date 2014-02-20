<?$timea=microtime();?>
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
		<link href="/video-js/video-js.css" rel="stylesheet">
		<script src="/video-js/video.js"></script>
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
					<h3><? echo $_GET["name"]."  ".$_GET["num"];?></h3>
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


