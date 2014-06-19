<html>
<head>

<!--   Imp: Layers are not used here.   -->


<link rel="stylesheet" href="zoom/assets/styles.css" type="text/css" />
<script src="zoom/assets/jquery-1.7.1.min.js"></script>
<script src="zoom/assets/zoom-jquery.js"></script>

<script>
<!-- zoom fuction is to be written -->

$(document).ready(function()
{
	/* This is for the zooming part.*/
	$('#myImgId').smartZoom({'containerClass':'zoomableContainer'});

	$('#topPositionMap,#leftPositionMap,#rightPositionMap,#bottomPositionMap').bind("click", moveButtonClickHandler);


	$('#zoomInButton,#zoomOutButton').bind("click", zoomButtonClickHandler);

	function zoomButtonClickHandler(e){
		var scaleToAdd = 0.1;
		if(e.target.id == 'zoomOutButton')
		scaleToAdd = -scaleToAdd;
		$('#myImgId').smartZoom('zoom', scaleToAdd);
	}

	/* This is for the movable part of the image */

	function moveButtonClickHandler(e){
		var pixelsToMoveOnX = 0;
		var pixelsToMoveOnY = 0;

		switch(e.target.id){
			case "leftPositionMap":
				pixelsToMoveOnX = 200;
				break;
			case "righttPositionMap":
				pixelsToMoveOnX = -200;
				break;
			case "topPositionMap":
				pixelsToMoveOnY = 200;
				break;
			case "bottomPositionMap":
				pixelsToMoveOnY = -200;
				break;
		}
		$('#myImgId').smartZoom('pan', pixelsToMoveOnX, pixelsToMoveOnY);
	}

});

</script>



<script>
function FindPosition(oElement)
{
	if(typeof( oElement.offsetParent ) != "undefined")
	{
		for(var posX = 0, posY = 0; oElement; oElement = oElement.offsetParent)
		{
			posX += oElement.offsetLeft;
			posY += oElement.offsetTop;
		}
		return [ posX, posY ];
	}
	else
	{
		return [ oElement.x, oElement.y ];
	}
}


function GetCoordinates(e)
{
	var PosX = 0;
	var PosY = 0;
	var ImgPos;
	ImgPos = FindPosition(myImg);
	if (!e) var e = window.event;
	if (e.pageX || e.pageY)
	{
		PosX = e.pageX;
		PosY = e.pageY;
	}
	else if (e.clientX || e.clientY)
	{
		PosX = e.clientX + document.body.scrollLeft
			+ document.documentElement.scrollLeft;
		PosY = e.clientY + document.body.scrollTop
			+ document.documentElement.scrollTop;
	}
	PosX = PosX - ImgPos[0];
	PosY = PosY - ImgPos[1];
	var i = 0;
	var j = 0;
	for(i = 0; i < count; i++ ) {
		if(strarr[i]==1) {
			j++;
		}
		else if(strarr[i]==2) {
			j--;
		}
	}
	if(j==0) {
		alert('same as initial');
	}
	else {
		for(i = 0; i < count; i++ ) {
			if(strarr[i]==1) {
				if(zin9==0) {
					actleft += 0.9*49;
					actright += 980 - 0.9*49;
					acttop += 0.9*25;
					actbottom += 250 - 0.9*25;
					zin9 = 1;
				}
				else {
					var l1=1;
					for(j=0;j<=zin9;j++) {
						l1 = l1*0.9;
					}
					actleft += l1*49;
					actright -= l1*49;
					acttop += l1*25;
					actbottom -= l1*25;
					zin9 += 1;
				}
			}
			if(strarr[i]==2) {
				var l1=1;
				for(j=0;j<=zin9;j++) {
					l1 = l1*0.9;
				}
				actleft -= l1*49;
				actright += l1*49;
				acttop -= l1*25;
				actbottom += l1*25;
				zin9 -= 1;
				if(actleft<=0) {
					actleft = 0;
				}
				if(actright<=0) {
					actright = 0;
				}
				if(acttop<=0) {
					acttop = 0;
				}
				if(actbottom<=0) {
					actbottom = 0;
				}
			}
			if(strarr[i]==3) {
				acttop -= 200;
				actbottom -= 200;
				if(acttop<=0) {
					acttop = 0;
				}
				if(actbottom<=0) {
					actbottom = 0;
				}
			}
			if(strarr[i]==4) {
				actleft -= 200;
				actright -= 200;
				if(actleft<=0) {
					actleft = 0;
				}
				if(actright<=0) {
					actright = 0;
				}
			}
			if(strarr[i]==5) {
				actleft += 200;
				actright += 200;
				if(actleft<=0) {
					actleft = 0;
				}
				if(actright>=980) {
					actright = 980;
				}
			}
			if(strarr[i]==6) {
				acttop += 200;
				actbottom += 200;
				if(acttop<=0) {
					acttop = 0;
				}
				if(actbottom>=500) {
					actbottom = 500;
				}
			}
		}
	}
	document.getElementById("x").innerHTML = PosX;
	document.getElementById("y").innerHTML = PosY;
}
</script>


<script>
var baseImage = new Image( 
	<?php
		$base = $_SESSION["baseImage"];
		echo "\"$base->url\", $base->width, $base->height";
	?>
);
var subImage = new Image(
	<?php
		$sub = $_SESSION['subImages'][$_SESSION['subCount']-1];
		echo "\"$sub->url\", $sub->width, $sub->height";
	?>
);
</script>



</head>

<body>

<div>
<h3>zoom the image</h3>
</div>

<div>
	<div id="pageContent">
		<div id="imgContainer">
			<img id="myImgId" src="<?php echo $base->url; ?>" height="500px" width="980px"/>
		</div>
		<script type="text/javascript">
			var myImg = document.getElementById("myImgId");
			myImg.onmousedown = GetCoordinates;
		</script>
		<div id="positionButtonDiv">
			<span>
				<img id="zoomInButton" class="zoomButton" src="zoom/img/zoom_in_button.png" title="zoom in" alt="zoom in" />
				<img id="zoomOutButton" class="zoomButton" src="zoom/img/zoom-out.jpg" title="zoom out" alt="zoom out" />
			</span>
			<span class="positionButtonSpan">
				<map name="positionMap" class="positionMapClass">
				<area id="topPositionMap" shape="rect" coords="20,0,40,20" title="move up" alt="move up"/>
				<area id="leftPositionMap" shape="rect" coords="0,20,20,40" title="move left" alt="move left"/>
				<area id="rightPositionMap" shape="rect" coords="40,20,60,40" title="move right" alt="move right"/>
				<area id="bottomPositionMap" shape="rect" coords="20,40,40,60" title="move bottom" alt="move bottom"/>
				</map>
				<img src="zoom/img/position.png" usemap="#positionMap"/>
			</span>
		</div>
		<div>
			<img src="<?php echo $sub->url; ?>" height="250px" width="490px"/>
			<br>
			<br>
		</div>
	</div>
	<script type="text/javascript">
		var strarr = new Array();
		var count;
		count = 0;
		var actleft = 0;
		var acttop = 0;
		var actbot = 0;
		var actright = 0;
		$('#zoomInButton').click(function() {
			strarr[count] = 1;
			count += 1;
			alert(count);
		});
		$( "#zoomOutButton" ).click(function() {
			strarr[count] = 2;
			count += 1;
			alert(strarr[count-1]);
		});
		$( "#topPositionMap" ).click(function() {
			strarr[count] = 3;
			count += 1;
			alert(strarr[count-1]);
		});
		$( "#leftPositionMap" ).click(function() {
			strarr[count] = 4;
			count += 1;
			alert(strarr[count-1]);
		});
		$( "#rightPositionMap" ).click(function() {
			strarr[count] = 5;
			count += 1;
			alert(strarr[count-1]);
		});
		$( "#bottomPositionMap" ).click(function() {
			strarr[count] = 6;
			count += 1;
			alert(strarr[count-1]);
		});
	</script>
</div>

</body>
</html>
