<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" value="IE=9">
		<link rel="stylesheet" href="css/base.css?1" />
		<title>New Interface Test for ABPlayer</title>
		<script src="/abplayer/mobile.js"></script>
		<script src="/abplayer/CommentCore.js"></script>
		<script src="/abplayer/libxml.js"></script>
		<script src="/abplayer/Parsers.js"></script>
		<script src="/abplayer/player.js"></script>
		<script type="text/javascript">
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
		<div id="player1" class="ABP-Unit" style="width:640px;height:480px;" tabindex="1">
			<div class="ABP-Video">
				<div class="ABP-Container"></div>
				<video id="abp-video" autobuffer="true" data-setup="{}">
					<source src="https://s3-us-west-1.amazonaws.com/ccltestingvideos/otsukimi_recital.webm" type="video/webm">
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
				<div class="progress-bar">
					<div class="bar dark"></div>
					<div class="bar"></div>
				</div>
				<div class="button ABP-CommentShow"></div>
				<div class="button ABP-FullScreen"></div>
			</div>
		</div>
		<div id="myDiv"></div>
		<p>Supports mobile. Swipe right to play, left to pause. Up to increase volume and down to decrease volume. Mobile interface auto-enabled on mobile devices.</p>
	</body>
</html>
