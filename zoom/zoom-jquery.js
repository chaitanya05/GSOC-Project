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
	}
}
