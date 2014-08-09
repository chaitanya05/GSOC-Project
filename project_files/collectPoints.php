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
	var myvalue1 = "false";
	if(myvalue1=="false") {
	$('#myImgId').smartZoom({'containerClass':'zoomableContainer'});

	$('#topPositionMap,#leftPositionMap,#rightPositionMap,#bottomPositionMap').bind("click", moveButtonClickHandler);

	
	$('#zoomInButton,#zoomOutButton').bind("click", zoomButtonClickHandler);
	}

	//document.getElementById("topPositionMap").style.pointerEvents = 'none';
	/*$("topPositionMap").click(function() {
		$(this).bind();
	});*/
	
	function zoomButtonClickHandler(e){
		if(myvalue1 == "false") {
			myvalue1 = "true";
			var scaleToAdd = 100;
			if(e.target.id == 'zoomOutButton')
			scaleToAdd = -scaleToAdd;
			$('#myImgId').smartZoom('zoom', scaleToAdd);
			setTimeout(function(){myvalue1="false"},3000);
		}
	}

	/* This is for the movable part of the image */

	function moveButtonClickHandler(e){
		if(myvalue1 == "false") {
		myvalue1 = "true";
		var pixelsToMoveOnX = 0;
		var pixelsToMoveOnY = 0;

		switch(e.target.id){
			case "leftPositionMap":
				pixelsToMoveOnX = 200;
				break;
			case "rightPositionMap":
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
		setTimeout(function(){myvalue1="false"},3000);
		}
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
	var zin9 = 0;
	for(i = 0; i < count; i++ ) {
		if(strarr[i]==1) {
			j++;
		}
		else if(strarr[i]==2) {
			j--;
		}
	}
	if(j==0) {
		//alert('same as initial');
	}
	else {
		for(i = 0; i < count; i++ ) {
			if(strarr[i]==1) {
				if(zin9==0) {
					actleft = 326.666;
					actright = 653.333;
					acttop = 166.333;
					actbottom = 333.666;
					zin9 = 1;
				}
			}
			if(strarr[i]==2) {
				if(zin9==1) {
					actleft = 0;
					actright = 980;
					acttop = 0;
					actbottom = 500;
					zin9 = 0;
				}
			}
			if(strarr[i]==3) {
				if(acttop-67>=0) {
					acttop -= 67;
					actbottom -= 67;
				}
				else if(acttop>=0) {
					actbottom = actbottom - acttop;
					acttop = 0;
				}
			}
			if(strarr[i]==4) {
				if(actleft-67.3333>=0) {
					actleft -= 67.3333;
					actright -= 67.333;
				}
				else if(actleft>=0) {
					actright = actright - actleft;
					actleft = 0;
				}
			}
			if(strarr[i]==5) {
				if(actright+67.3333<=980) {
					actleft += 67.3333;
					actright += 67.3333;
				}
				else if(actright<=980) {
					actleft = actleft + 980 - actright;
					actright = 980;
				}
			}
			if(strarr[i]==6) {
				if(actbottom+67.3333<=500) {
					acttop += 67.3333;
					actbottom += 67.3333;
				}
				else if(actbottom<=500) {
					acttop = acttop + 500 - actbottom;
					actbottom = 500;
				}
			}
		}
	}
	if(zin9>0) {
		//alert(actleft);
		PosX = actleft + PosX*(actright-actleft)/980;
		PosY = acttop + PosY*(actbottom-acttop)/500;
		zin9 = 0;
		actleft = 0;
		actright = 0;
		acttop = 0;
		actbottom = 0;
	}
	//alert(actleft);
	//alert(actright);
	if(count1<=2) {
		if(count1==0) {
			finarray[0]=PosX;
			finarray[1]=PosY;
		}
		else if(count1==2) {
			finarray[2]=PosX;
			finarray[3]=PosY;
		}
	}
	mainarray[count1]=PosX;
	count1 += 1;
	mainarray[count1]=PosY;
	count1 += 1;
	document.getElementById("x").innerHTML = PosX;
	document.getElementById("y").innerHTML = PosY;
}
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


function Coordinates(e)
{
        var PosX = 0;
        var PosY = 0;
        var ImgPos;
        ImgPos = FindPosition(subImg);
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
	if(subcount1<2) {
		if(subcount1==0) {
			finarray[4]=PosX;
			finarray[5]=PosY;
		}
		else if(subcount1==1) {
			finarray[6]=PosX;
			finarray[7]=PosY;
			var str = JSON.stringify(finarray);
			sessionStorage.finarray = str;
		}
	}
	subcount1++;
        document.getElementById("x1").innerHTML = PosX;
        document.getElementById("y1").innerHTML = PosY;
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
		<?php
			//echo $sub->url;
		?>
		<script type="text/javascript">
			var myImg = document.getElementById("myImgId");
			myImg.onmousedown = GetCoordinates;
		</script>
		<p>X1:<span id="x"></span></p>
		<p>Y1:<span id="y"></span></p>

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
			<img id="subId1" src="<?php echo $sub->url; ?>" height="500px" width="980px"/>
	                <script type="text/javascript">
	                        var subImg = document.getElementById("subId1");
	                        subImg.onmousedown = Coordinates;
	                </script>
	                <p>X2:<span id="x1"></span></p>
        	        <p>Y2:<span id="y1"></span></p>

			<br>
			<br>
		</div>
	<form id="myForm" action="displayResults.php" method="post" > 
		<input type="hidden" id="str" name="str" value="" /> 
		<input type="submit" id="btn" name="submit" value="Submit" />
	</form>

	<span id="result"></span>

	<script>
	$(document).ready(function(){
		/*if(count1>=1) {
			alert('attack');
		}
		if(count1>=1) {*/
		$("#btn").click( function(e) {
			//e.preventDefault();
			$.post( $("#myForm").attr("action"),
			$('#str').val(JSON.stringify(finarray)),  
			//$("#myForm :input").serializeArray(), 
			function(info){ 
			$("#result").html(info);
			//alert(info);
			; 
			});
		});

		//}
	});
	</script>
		<!-- <button onclick="location.href ='displayResults.php';" id="myButton" value="gotWorldFile" class="submit-button" >Generate</button> -->
	</div>
	<script type="text/javascript">
		var height = <?php echo $base->height; ?>;
		var width = <?php echo $base->width; ?>;
		var strarr = new Array();
		var mainarray = new Array();
		var subarray = new Array();
		var finarray = new Array();
		var count;
		var count1;
		var subcount1;
		finarray[8]="<?php echo $base->url; ?>";
		finarray[9]="<?php echo $sub->url; ?>";
		count1 = 0;
		count = 0;
		subcount1 = 0;
		var actleft = 0;
		var acttop = 0;
		var actbottom = 0;
		var actright = 0;
		var zin = 0;
		var zout = 0;
		var mleft = 0;
		var mright = 0;
		var mleft = 0;
		var mtop = 0;
		$('#zoomInButton').click(function() {
                        if(strarr[count-1]==2) {
                                count = count-1;
                        }
                        else {
				strarr[count] = 1;
				count += 1;
			}
		});
		$( "#zoomOutButton" ).click(function() {
                        if(strarr[count-1]==1) {
                                count = count-1;
                        }
                        else if(count>=1) {
				strarr[count] = 2;
				count += 1;
			}
		});
		$( "#topPositionMap" ).click(function() {
                        if(strarr[count-1]==6) {
                                count = count-1;
                        }
                        else if(count>=1) {
				strarr[count] = 3;
				count += 1;
			}
		});
		$( "#leftPositionMap" ).click(function() {
                        if(strarr[count-1]==5) {
                                count = count-1;
                        }
                        else if(count>=1) {
				strarr[count] = 4;
				count += 1;
			}
		});
		$( "#rightPositionMap" ).click(function() {
                        if(strarr[count-1]==4) {
                                count = count-1;
                        }
                        else if(count>=1) {
				strarr[count] = 5;
				count += 1;
			}
		});
		$( "#bottomPositionMap" ).click(function() {
                        if(strarr[count-1]==3) {
                                count = count-1;
                        }
                        else if(count>=1) {
				strarr[count] = 6;
				count += 1;
			}
		});
	</script>

</div>
</body>
</html>
