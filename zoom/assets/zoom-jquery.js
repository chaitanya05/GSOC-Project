(function(e){
 	e.fn.smartZoom=function(t){
		function r(e){}function s(e,t){
			var r=n.data("smartZoomData");
			if(r.currentWheelDelta*t<0)r.currentWheelDelta=0;
			r.currentWheelDelta+=t;
			i.zoom(r.mouseWheelDeltaFactor*r.currentWheelDelta,{x:e.pageX,y:e.pageY})
		}
		function o(e){
			e.preventDefault()
		}
		function u(){
			var e=n.data("smartZoomData");
			if(e.settings.mouseMoveEnabled!=true||e.settings.moveCursorEnabled!=true)return;
			var t=S();
			var r=t.width/e.originalSize.width;
			if(parseInt(r*100)>parseInt(e.adjustedPosInfos.scale*100))n.css({cursor:"move"});
			else n.css({cursor:"default"})
		}
		function a(e){
			m(e.pageX,e.pageY)
		}
		function f(t){
			t.preventDefault();
			e(document).on("mousemove.smartZoom",l);
			e(document).bind("mouseup.smartZoom",c);
			var r=n.data("smartZoomData");
			r.moveCurrentPosition=new A(t.pageX,t.pageY);
			r.moveLastPosition=new A(t.pageX,t.pageY)
		}
		function l(e){
			var t=n.data("smartZoomData");
			if(t.mouseMoveForPan||!t.mouseMoveForPan&&t.moveCurrentPosition.x!=e.pageX&&t.moveCurrentPosition.y!=e.pageY){
				t.mouseMoveForPan=true;
				v(e.pageX,e.pageY,0,false)
			}
		}
		function c(t){
			var r=n.data("smartZoomData");
			if(r.mouseMoveForPan){
				r.mouseMoveForPan=false;
				if(r.moveLastPosition.distance(r.moveCurrentPosition)>4){
					var i=r.moveLastPosition.interpolate(r.moveCurrentPosition,-4);
					v(i.x,i.y,500,true)
				}
				else{
					v(r.moveLastPosition.x,r.moveLastPosition.y,0,true)
				}
			}
			else if(r.settings.zoomOnSimpleClick){
				m(t.pageX,t.pageY)
			}
			e(document).unbind("mousemove.smartZoom");
			e(document).unbind("mouseup.smartZoom")
		}
		function h(t){
			t.preventDefault();
			e(document).unbind("touchmove.smartZoom");
			e(document).unbind("touchend.smartZoom");
			e(document).bind("touchmove.smartZoom",p);
			e(document).bind("touchend.smartZoom",d);
			var r=t.originalEvent.touches;
			var i=r[0];
			var s=n.data("smartZoomData");
			s.touch.touchMove=false;
			s.touch.touchPinch=false;
			s.moveCurrentPosition=new A(i.clientX,i.clientY);
			s.moveLastPosition=new A(i.clientX,i.clientY);
			s.touch.lastTouchPositionArr=new Array;
			var o;
			var u=r.length;
			for(var a=0;a<u;++a){
				o=r[a];
				s.touch.lastTouchPositionArr.push(new A(o.clientX,o.clientY))
			}
		}
		function p(e){
			e.preventDefault();
			var t=n.data("smartZoomData");
			var r=e.originalEvent.touches;
			var s=r.length;
			var o=r[0];
			if(s==1&&!t.touch.touchPinch&&t.settings.touchMoveEnabled==true){
				t.touch.touchMove=true;
				v(o.clientX,o.clientY,0,false)
			}
			else if(s==2&&!t.touch.touchMove&&t.settings.pinchEnabled==true){
				t.touch.touchPinch=true;
				var u=r[1];
				var a=t.touch.lastTouchPositionArr[0];
				var f=t.touch.lastTouchPositionArr[1];
				var l=new A(o.clientX,o.clientY);
				var c=new A(u.clientX,u.clientY);
				var h=l.distance(c);
				var p=a.distance(f);
				var d=h-p;
				if(Math.abs(d)<3)return;
				var m=new A((l.x+c.x)/2,(l.y+c.y)/2);
				var g=S();
				var y=t.originalSize;
				var b=g.width/y.width;
				var w=h/p;
				var E=g.width*w/y.width;
				i.zoom(E-b,m,0);
				t.touch.lastTouchPositionArr[0]=l;
				t.touch.lastTouchPositionArr[1]=c
			}
		}
		function d(t){
			t.preventDefault();
			var r=t.originalEvent.touches.length;
			if(r==0){
				e(document).unbind("touchmove.smartZoom");
				e(document).unbind("touchend.smartZoom")
			}
			var i=n.data("smartZoomData");
			if(i.touch.touchPinch)return;
			if(i.touch.touchMove){
				if(i.moveLastPosition.distance(i.moveCurrentPosition)>1){
					var s=i.moveLastPosition.interpolate(i.moveCurrentPosition,-4);
					v(s.x,s.y,500,true)
				}
			}
			else{
				if(i.settings.dblTapEnabled==true&&i.touch.lastTouchEndTime!=0&&(new Date).getTime()-i.touch.lastTouchEndTime<300){
					var o=i.touch.lastTouchPositionArr[0];
					m(o.x,o.y)
				}
				i.touch.lastTouchEndTime=(new Date).getTime()
			}
		}
		function v(e,t,i,s){
			g(r.PAN);
			var o=n.data("smartZoomData");
			o.moveLastPosition.x=o.moveCurrentPosition.x;
			o.moveLastPosition.y=o.moveCurrentPosition.y;
			var u=n.offset();
			var a=S();
			var f=u.left+(e-o.moveCurrentPosition.x);
			var l=u.top+(t-o.moveCurrentPosition.y);
			var c=y(f,l,a.width,a.height);
			x(r.PAN,r.START,false);
			E(n,c.x,c.y,a.width,a.height,i,s==true?function(){x(r.PAN,r.END,false)}:null);
			o.moveCurrentPosition.x=e;
			o.moveCurrentPosition.y=t
		}
		function m(e,t){
			var r=n.data("smartZoomData");
			var s=r.originalSize;
			var o=S();
			var u=o.width/s.width;
			var a=r.adjustedPosInfos.scale;
			var f=parseFloat(r.settings.dblClickMaxScale);
			var l;
			if(u.toFixed(2)>f.toFixed(2)||Math.abs(f-u)>Math.abs(u-a)){
				l=f-u
			}
			else{
				l=a-u
			}
			i.zoom(l,{x:e,y:t})
		}
		function g(e){
			var t=n.data("smartZoomData");
			if(t.transitionObject){
				if(t.transitionObject.cssAnimTimer)clearTimeout(t.transitionObject.cssAnimTimer);
				var r=t.originalSize;
				var i=S();
				var s=new Object;
				s[t.transitionObject.transition]="all 0s";
				if(t.transitionObject.css3dSupported){
					s[t.transitionObject.transform]="translate3d("+i.x+"px, "+i.y+"px, 0) scale3d("+i.width/r.width+","+i.height/r.height+", 1)"
				}
				else{
					s[t.transitionObject.transform]="translateX("+i.x+"px) translateY("+i.y+"px) scale("+i.width/r.width+","+i.height/r.height+")"
				}
				n.css(s)
			}
			else{
				n.stop()
			}
			u();
			if(e!=null)x(e,"",true)
		}
		function y(e,t,r,i){
			var s=n.data("smartZoomData");
			var o=Math.min(s.adjustedPosInfos.top,t);
			o+=Math.max(0,s.adjustedPosInfos.top+s.adjustedPosInfos.height-(o+i));
			var u=Math.min(s.adjustedPosInfos.left,e);
			u+=Math.max(0,s.adjustedPosInfos.left+s.adjustedPosInfos.width-(u+r));
			return new A(u.toFixed(2),o.toFixed(2))
		}
		function b(e){
			n.unbind("load.smartZoom");
			i.init.apply(n,[e.data.arguments])
		}
		function w(){
			var e=n.data("smartZoomData");
			var t=e.containerDiv;
			var r=e.originalSize;
			var i=t.parent().offset();
			var s=C(e.settings.left,i.left,t.parent().width());
			var o=C(e.settings.top,i.top,t.parent().height());
			t.offset({left:s,top:o});
			t.width(N(e.settings.width,t.parent().width(),s-i.left));
			t.height(N(e.settings.height,t.parent().height(),o-i.top));
			var a=L(t);
			var f=Math.min(Math.min(a.width/r.width,a.height/r.height),1).toFixed(2);
			var l=r.width*f;
			var c=r.height*f;
			e.adjustedPosInfos={left:(a.width-l)/2+i.left,top:(a.height-c)/2+i.top,width:l,height:c,scale:f};
			g();
			E(n,e.adjustedPosInfos.left,e.adjustedPosInfos.top,l,c,0,function(){n.css("visibility","visible")});
			u()
		}
		function E(e,t,r,i,s,o,u){
			var a=n.data("smartZoomData");
			var f=a.containerDiv.offset();
			var l=t-f.left;
			var c=r-f.top;
			if(a.transitionObject!=null){
				var h=a.originalSize;
				var p=new Object;
				p[a.transitionObject.transform+"-origin"]="0 0";
				p[a.transitionObject.transition]="all "+o/1e3+"s ease-out";
				if(a.transitionObject.css3dSupported)p[a.transitionObject.transform]="translate3d("+l+"px, "+c+"px, 0) scale3d("+i/h.width+","+s/h.height+", 1)";
				else p[a.transitionObject.transform]="translateX("+l+"px) translateY("+c+"px) scale("+i/h.width+","+s/h.height+")";
				e.css(p);
				if(u!=null)a.transitionObject.cssAnimTimer=setTimeout(u,o)
			}
			else{
				e.animate({"margin-left":l,"margin-top":c,width:i,height:s},{duration:o,easing:a.settings.easing,complete:function(){if(u!=null)u()}})
			}
		}
		function S(e){
			var t=n.data("smartZoomData");
			var r=n.width();
			var i=n.height();
			var s=n.offset();
			var o=parseInt(s.left);
			var u=parseInt(s.top);
			var a=t.containerDiv.offset();
			if(e!=true){
				o=parseInt(o)-a.left;
				u=parseInt(u)-a.top
			}
			if(t.transitionObject!=null){
				var f=n.css(t.transitionObject.transform);
				if(f&&f!=""&&f.search("matrix")!=-1){
					var l;
					var c;
					if(f.search("matrix3d")!=-1){
						c=f.replace("matrix3d(","").replace(")","").split(",");
						l=c[0]
					}
					else{
						c=f.replace("matrix(","").replace(")","").split(",");
						l=c[3];
						o=parseFloat(c[4]);
						u=parseFloat(c[5]);
						if(e){
							o=parseFloat(o)+a.left;
							u=parseFloat(u)+a.top
						}
					}
					r=l*r;
					i=l*i
				}
			}
			return{x:o,y:u,width:r,height:i}
		}
		function x(e,t,i){
			var s=n.data("smartZoomData");
			var o="";
			if(i==true&&s.currentActionType!=e){
				o=s.currentActionType+"_"+r.END;
				s.currentActionType="";
				s.currentActionStep=""
			}
			else{
				if(s.currentActionType!=e||s.currentActionStep==r.END){
					s.currentActionType=e;
					s.currentActionStep=r.START;
					o=s.currentActionType+"_"+s.currentActionStep
				}
				else if(s.currentActionType==e&&t==r.END){
					s.currentActionStep=r.END;
					o=s.currentActionType+"_"+s.currentActionStep;
					s.currentActionType="";
					s.currentActionStep=""
				}
			}
			if(o!=""){
				var u=jQuery.Event(o);
				u.targetRect=S(true);
				u.scale=u.targetRect.width/s.originalSize.width;n.trigger(u)
			}
		}
		function T(){
			if(jQuery.browser.opera)return null;
			var t=document.body||document.documentElement;
			var n=t.style;
			var r=["transition","WebkitTransition","MozTransition","MsTransition","OTransition"];
			var i=["transition","-webkit-transition","-moz-transition","-ms-transition","-o-transition"];
			var s=["transform","-webkit-transform","-moz-transform","-ms-transform","-o-transform"];
			var o=r.length;
			var u;
			for(var a=0;a<o;a++){
				if(n[r[a]]!=null){
					transformStr=s[a];
					var f=e('<div style="position:absolute;">Translate3d Test</div>');
					e("body").append(f);
					u=new Object;
					u[s[a]]="translate3d(20px,0,0)";
					f.css(u);
					css3dSupported=f.offset().left==20;
					f.empty().remove();
					if(css3dSupported){
						return{transition:i[a],transform:s[a],css3dSupported:css3dSupported}
					}
				}
			}
			return null
		}
		function N(e,t,n){
			if(e.search&&e.search("%")!=-1)return(t-n)*(parseInt(e)/100);
			else return parseInt(e)
		}
		function C(e,t,n){
			if(e.search&&e.search("%")!=-1)return t+n*(parseInt(e)/100);
			else return t+parseInt(e)
		}
		function k(){
			w()
		}
		function L(e){
			var t=e.offset();
			if(!t)return null;
			var n=t.left;
			var r=t.top;
			return{x:n,y:r,width:e.outerWidth(),height:e.outerHeight()}
		}
		function A(e,t){
			this.x=e;
			this.y=t;
			this.toString=function(){return"(x="+this.x+", y="+this.y+")"};
			this.interpolate=function(e,t){var n=t*this.x+(1-t)*e.x;var r=t*this.y+(1-t)*e.y;return new A(n,r)};
			this.distance=function(e){return Math.sqrt(Math.pow(e.y-this.y,2)+Math.pow(e.x-this.x,2))}
		}
		var n=this;
		r.ZOOM="SmartZoom_ZOOM";
		r.PAN="SmartZoom_PAN";
		r.START="START";
		r.END="END";
		var i={init:function(t){if(n.data("smartZoomData"))return;settings=e.extend({top:"0",left:"0",width:"100%",height:"100%",easing:"smartZoomEasing",maxScale:3,dblClickMaxScale:1.8,mouseEnabled:true,scrollEnabled:true,dblClickEnabled:true,mouseMoveEnabled:true,moveCursorEnabled:true,touchEnabled:true,dblTapEnabled:true,zoomOnSimpleClick:false,pinchEnabled:true,touchMoveEnabled:true,containerBackground:"#FFFFFF",containerClass:""},t);var r="smartZoomContainer"+(new Date).getTime();var i=e('<div id="'+r+'" class="'+settings.containerClass+'"></div>');n.before(i);n.remove();i=e("#"+r);i.css({overflow:"hidden"});if(settings.containerClass=="")i.css({"background-color":settings.containerBackground});i.append(n);var u=new Object;u.lastTouchEndTime=0;u.lastTouchPositionArr=null;u.touchMove=false;u.touchPinch=false;
			n.data("smartZoomData",{settings:settings,containerDiv:i,originalSize:{width:n.width(),height:n.height()},originalPosition:n.offset(),transitionObject:T(),touch:u,mouseWheelDeltaFactor:.15,currentWheelDelta:0,adjustedPosInfos:null,moveCurrentPosition:null,moveLastPosition:null,mouseMoveForPan:false,currentActionType:"",currentActionStep:""});w();if(settings.touchEnabled==true)n.bind("touchstart.smartZoom",h);if(settings.mouseEnabled==true){if(settings.mouseMoveEnabled==true)n.bind("mousedown.smartZoom",f);if(settings.scrollEnabled==true){i.bind("mousewheel.smartZoom",s);i.bind("mousewheel.smartZoom DOMMouseScroll.smartZoom",o)}if(settings.dblClickEnabled==true&&settings.zoomOnSimpleClick==false)i.bind("dblclick.smartZoom",a)}document.ondragstart=function(){return false};e(window).bind("resize.smartZoom",k)},zoom:function(e,t,i){var s=n.data("smartZoomData");var o;var a;if(!t){var f=L(s.containerDiv);o=f.x+f.width/2;a=f.y+f.height/2}else{o=t.x;a=t.y}g(r.ZOOM);var l=S(true);var c=s.originalSize;var h=l.width/c.width+e;h=Math.max(s.adjustedPosInfos.scale,h);h=Math.min(s.settings.maxScale,h);var p=c.width*h;var d=c.height*h;var v=o-l.x;var m=a-l.y;var b=p/l.width;var w=l.x-(v*b-v);var T=l.y-(m*b-m);var N=y(w,T,p,d);if(i==null)i=700;x(r.ZOOM,r.START,false);E(n,N.x,N.y,p,d,i,function(){s.currentWheelDelta=0;u();x(r.ZOOM,r.END,false)})},pan:function(e,t,i){if(e==null||t==null)return;if(i==null)i=700;var s=n.offset();var o=S();var u=y(s.left+e,s.top+t,o.width,o.height);if(u.x!=s.left||u.y!=s.top){g(r.PAN);x(r.PAN,r.START,false);E(n,u.x,u.y,o.width,o.height,i,function(){x(r.PAN,r.END,false)})}},destroy:function(){var t=n.data("smartZoomData");if(!t)return;g();var r=t.containerDiv;n.unbind("mousedown.smartZoom");n.bind("touchstart.smartZoom");r.unbind("mousewheel.smartZoom");r.unbind("dblclick.smartZoom");r.unbind("mousewheel.smartZoom DOMMouseScroll.smartZoom");e(window).unbind("resize.smartZoom");e(document).unbind("mousemove.smartZoom");e(document).unbind("mouseup.smartZoom");e(document).unbind("touchmove.smartZoom");e(document).unbind("touchend.smartZoom");n.css({cursor:"default"});r.before(n);E(n,t.originalPosition.left,t.originalPosition.top,t.originalSize.width,t.originalSize.height,5);n.removeData("smartZoomData");r.remove()},isPluginActive:function(){return n.data("smartZoomData")!=undefined}
		}
	}
}
