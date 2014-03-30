<?$timea=microtime();?>
<!DOCTYPE html>
<html>
	<head>
		<title>关于 新番</title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">
		<link href="dist/css/bootstrap.css" rel="stylesheet">
		<link href="css/main.css" rel="stylesheet">
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
						<li><a href="list.php">文件列表</a></li>
						                   <li><a href="localplay.php">本地播放</a><li>

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
					<h3>关于</h3>
				</div>
				<div class="panel panel-default">
					<div class="panel-body">
						<h4>缘由和目的</h4>
						<s>SB计算中心和校园网老子和你没完！</s><br>
						所以说为了方便我自己看新番蛋疼的花了3,4天写的网站。<br>
						有谁想增加视频请联系我。<br>
						本网站只对北大校内开放。谢绝备案和水表。
						<h4>视频源</h4>
					视频来自于互联网，torrent来自于<a href="http://bt.ktxp.com/">极影动漫</a><br>
					如有版权等问题<a href="https://plus.google.com/109339235070869782796/posts">请在Google Plus联系我</a><br>
					<h4>网站</h4>
					网站基于php,html5,css3.请使用支持html5的浏览器观看。
					网站前端设计采用了<a href="http://www.bootcss.com/">Bootstrap</a>框架。<br>
					网站使用<a href="http://flexget.com/">Flexget</a>插件订阅Rss自动下载torrent文件，并使用<a href="http://deluge-torrent.org/">deluge</a>下载。使用php检测下载文件夹并显示。<br>
					<h4>关于我</h4>
					请移步<a href="https://plus.google.com/109339235070869782796/posts">Google Plus</a><br>
					<h4>磁盘使用量</h4>
					<div class="progress">
						<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: <? echo (1-disk_free_space("/home/drive/xinfan")/(1000*1000*1000*2000))*100;?>%">
							</div><center>
							<? echo floor(disk_free_space("/home/drive/xinfan")/(1024*1024*1024))."GB 剩余";?>
					</center></div>
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


