<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<link href="/video-js/video-js.css" rel="stylesheet">
<script src="/video-js/video.js"></script>
<script>
videojs.options.flash.swf = "/video-js/video-js.swf"
</script>
<style type="text/css">
div#main
{
	top: 0px;
	background-color:#F5F5DC;
	margin-left: auto;
	margin-right: auto;
	width: 800px;
}
div#header
{
}
div#menu
{
}
div#content
{
	margin-left: auto;
	margin-right: auto;
}
</style>
<title><?php echo $_GET["name"].$_GET["num"]; ?></title>
</head>
<body>
<div id="main">
<div id="header">
<h1><?php echo $_GET["name"]."	".$_GET["num"]; ?><br>
</div>
<div id="content">
<video id="example_video_1" class="video-js vjs-default-skin"
controls preload="auto" width="800" height="480"
data-setup='{"example_option":true}'>
<source src=<?php echo "/files/".rawurlencode($_GET["file"]);?> type='video/mp4' />
</div>
</div>
</body>
</html>


