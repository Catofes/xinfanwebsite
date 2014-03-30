function GetRequest() {
	var url = location.search;
	var theRequest = new Object();
	if (url.indexOf("?") != -1) {
		var str = url.substr(1);
		strs = str.split("&");
		for(var i = 0; i < strs.length; i ++) {
			theRequest[strs[i].split("=")[0]]=decodeURI(strs[i].split("=")[1]);
		}
	}
	return theRequest;
}

function reload(cid){
	if(window.thevideojs.cmManager.display==true){
		window.thevideojs.cmManager.display=false;
		window.thevideojs.cmManager.clear();
		window.thevideojs.cmManager.stopTimer();
	}
	window.thevideojs.CommentLoader("http://comment.bilibili.cn/"+cid+".xml",CL_finish);
	window.thevideojs.cmManager.display = true;
	window.thevideojs.cmManager.startTimer();
}

function CL_finish(statu){
	if(statu==true)
	  echoinfo(101);
}

function echoinfo(inf){
	switch(inf){
		case 101:
			document.getElementById("status").textContent="弹幕载入完毕";
			break;
		case 201:
			document.getElementById("status").textContent="弹幕载入失败";
			break;
		case 202:
			document.getElementById("status").textContent="视频404～";
			break;
		case 203:
			document.getElementById("status").textContent="自动载入失败";
			break;
		case 301:
			document.getElementById("status").textContent="弹幕载入中";
			break;
		case 302:
			document.getElementById("status").textContent="自动加载弹幕中";
			break;
		case 303:
			document.getElementById("status").textContent="专辑已找到，加载中";
			break;
		case 304:
			document.getElementById("status").textContent="专辑号加载失败，重新搜索专辑";
			break;
		case 305:
			document.getElementById("status").textContent="视频已找到，加载中";
			break;
	}
}

function j_DmLoad(data){
	if(data.cid>0){
		document.getElementById("bilibili").textContent="弹幕地址: "+data.title;
		document.getElementById("bilibili").href="http://www.bilibili.tv/video/av"+window.avcode;
		reload(data.cid);
		return;
		echoinfo(201);
	}
}

function DmGetby_av(av,page){
	var xmlhttp;
	if (window.XMLHttpRequest)
	  xmlhttp=new XMLHttpRequest();
	else
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			var url=xmlhttp.responseText+"&callback=j_DmLoad";
			var script=document.createElement('script');
			script.setAttribute('src', url);
			document.getElementsByTagName('head')[0].appendChild(script); 
		}
	}
	window.avcode=av;
	xmlhttp.open("GET","/danmu.php?f=gav&av="+av+'&page='+page,true);
	xmlhttp.send();
}

function j_Dmspid(data){
	if(data.code==0){
		if(data.list[window.Request['num']]){
			echoinfo(305);
			DmGetby_av(data.aid,1);
		}
		else {
			echoinfo(202);
			DmSearchby_name(window.Request['name'],window.Request['num']);
		}
	}
	else {
		echoinfo(304);
		DmGetby_name(window.Request['name'],window.Requets['num']);
	}
}

function DmGetby_spid(spid){
	var xmlhttp;	
	if (window.XMLHttpRequest)
	  xmlhttp=new XMLHttpRequest();
	else
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			var url=xmlhttp.responseText+"&callback=j_Dmspid";
			var script=document.createElement('script');
			script.setAttribute('src', url);
			document.getElementsByTagName('head')[0].appendChild(script);
		}
	}
	xmlhttp.open("GET","/danmu.php?f=spv&id="+spid,true);
	xmlhttp.send();
}

function j_Dmspt(data){
	if(data.spid>0){
		echoinfo(303);
		DmGetby_spid(data.spid);
	}
	else{
		echoinfo(306);
		DmSearchby_name(window.Request['name'],window.Request['num']);
	}
}

function j_DmSearch(data){
	if(data.code==0){
		if(data.property.result>0){
			echoinfo(305);
			if(window.pageid==data.page)
			  window.pageid=0;
			if(!data.result[0].aid){
				echoinfo(202);
				return;
			}
			DmGetby_av(data.result[0].aid,1);
			return;
		}
	}
	echoinfo(203);
}
function DmSearchby_name(name,num){
	var xmlhttp;
	if(!window.pageid)
		window.pageid=0;
	window.pageid++;
	if (window.XMLHttpRequest)
	  xmlhttp=new XMLHttpRequest();
	else
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			var url=xmlhttp.responseText+"&callback=j_DmSearch";
			var script=document.createElement('script');
			script.setAttribute('src', url);
			document.getElementsByTagName('head')[0].appendChild(script);
		}
	}
	if(!window.thename)
	  xmlhttp.open("GET","/danmu.php?f=search&name="+encodeURI(name)+"&num="+num+"&page="+window.pageid,true);
	else
	  xmlhttp.open("GET","/danmu.php?f=search&name="+encodeURI(window.thename)+"&num=&page="+window.pageid,true);
	xmlhttp.send();

}

function DmGetby_name(name){
	var xmlhttp;        
	if (window.XMLHttpRequest)
	  xmlhttp=new XMLHttpRequest();
	else
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			var url=xmlhttp.responseText+"&callback=j_Dmspt";
			var script=document.createElement('script');
			script.setAttribute('src', url);
			document.getElementsByTagName('head')[0].appendChild(script);
		}   
	}   
	xmlhttp.open("GET","/danmu.php?f=sps&name="+name,true);
	xmlhttp.send();

}

function DmAutoLoad(){
	echoinfo(302);
	var Request=GetRequest();
	window.Request=Request;
	if(Request['spid']='')
	  DmGetby_spid(Request['spid']);
	else 
	  //DmGetby_name(Request['name']);
	  DmSearchby_name(Request['name'],Request['num']);
}

function avgo(){
	var avcode=document.getElementById("theavcode").value;
	var page=document.getElementById("thepage").value;
	if(avcode>0){
		echoinfo(301);
		if(page>0)
		  DmGetby_av(avcode,page);
		else
		  DmGetby_av(avcode,1);
	}else
	  DmAutoLoad();
}

function onInputFileChange() {  
	var file = document.getElementById('file').files[0];  
	var url = URL.createObjectURL(file);  
	console.log(file.name);
	window.thevideojs.src(url);
}
window.settinghidden=true;

function setting()
{
	if(window.settinghidden){
		$('#setting').animate({"height":"100px"},"slow"); 
		window.settinghidden=false;
	}
	else{
		$('#setting').animate({"height":"0px"},"slow"); 
		window.settinghidden=true;
	}
};

function changeTitle()
{
	var thename = document.getElementById("changetitle").value;
	if(thename){
		window.pageid=0;
		window.thename=thename;
		$("#filetitle").text(thename);
	}
}
