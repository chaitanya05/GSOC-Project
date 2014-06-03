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
	}
}
