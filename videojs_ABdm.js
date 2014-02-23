vjs.plugin('ABP', ABPinit);
function ABPinit(){
	danmu_div = document.createElement('div');
	danmu_div.className = 'vjs-danmu';
	this.el().insertBefore(danmu_div,this.el().getElementsByClassName('vjs-poster')[0]);
	//vjs.Player.prototype.binddm = function(playerUnit){
	danmu_control = document.createElement('dev');
	danmu_control.className= 'vjs-danmu-control vjs-menu-button vjs-control';
	danmu_control_content = document.createElement('span');
	danmu_control_content.className='glyphicon glyphicon-eye-open';
	danmu_control.appendChild(danmu_control_content);
	this.el().getElementsByClassName('vjs-control-bar')[0].appendChild(danmu_control);
	this.binddm=function(){
		video=this.tag;
		if(typeof CommentManager !== "undefined"){
			this.cmManager = new CommentManager(this.el().getElementsByClassName('vjs-danmu')[0]);
			this.cmManager.display = true;
			this.cmManager.init();
			this.cmManager.clear();
			this.tag.cmManager=this.cmManager;
			window.cmManager=this.cmManager;
			var lastPosition = 0;
			/*if(1){
			  var autosize = function(){
			  if(vjs.Html5.prototype.width === 0 || vjs.Html5.prototype.height === 0){
			  return;
			  }
			  var aspectRatio = vjs.Html5.prototype.height / vjs.Html5.prototype.width;
			// We only autosize within the bounds
			var boundW = vjs.Html5.prototype.width;
			var boundH = vjs.Html5.prototype.height; 
			var oldASR = boundH / boundW;

			if(oldASR < aspectRatio){
			playerUnit.style.width = (boundH / aspectRatio) + "px";
			playerUnit.style.height = boundH  + "px";
			}else{
			playerUnit.style.width = boundW + "px";
			playerUnit.style.height = (boundW * aspectRatio) + "px";
			}

			vjs.Player.prototype.cmManager.setBounds();
			};
			video.addEventListener("loadedmetadata", autosize);
			autosize();
			}*/
			video.addEventListener("progress", function(){
				if(lastPosition == video.currentTime){
					video.hasStalled = true;
					this.cmManager.stopTimer();
				}else
				lastPosition = video.currentTime;
			});
			if(window){
				window.addEventListener("resize", function(){
					this.cmManager.setBounds();
				});
			}
			video.addEventListener("timeupdate", function(){
				if(this.cmManager.display === false) return;
				if(video.hasStalled){
					this.cmManager.startTimer();
					video.hasStalled = false;
				}
				this.cmManager.time(Math.floor(video.currentTime * 1000));
			});
			video.addEventListener("play", function(){
				this.cmManager.startTimer();
				try{
					var e = this.buffered.end(0);
					var dur = this.duration;
					var perc = (e/dur) * 100;
					vjs.barLoad.style.width = perc + "%";
				}catch(err){}	
			});
			video.addEventListener("ratechange", function(){
				if(this.cmManager.def.globalScale != null){
					if(video.playbackRate !== 0){
						this.cmManager.def.globalScale = (1 / video.playbackRate);
						this.cmManager.rescale();
					}
				}
			});
			video.addEventListener("pause", function(){
				this.cmManager.stopTimer();
			});
			video.addEventListener("waiting", function(){
				this.cmManager.stopTimer();
			});
			video.addEventListener("playing",function(){
				this.cmManager.startTimer();
			});
			video.addEventListener("seeked",function(){
				this.cmManager.clear();
			});

			this.el().getElementsByClassName("vjs-danmu-control")[0].addEventListener("click",function(){
				if(window.cmManager.display==true){
					window.cmManager.display=false;
					window.cmManager.clear();
					this.children[0].setAttribute("class","glyphicon glyphicon-eye-close");
				}else{
					window.cmManager.display=true;
					this.children[0].setAttribute("class","glyphicon glyphicon-eye-open");
				}
			});
		}
	}
	this.binddm();
};

