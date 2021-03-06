<html>
<head>
<title>Overlay two images</title>
<script src="zoom/assets/jquery-1.7.1.min.js"></script>

<?php
$output = array();
function js2php_proc() {
	if(isset($_POST['str'])) {
		$finarray = json_decode($_POST['str'], true);
	}
	if(!empty($finarray)) {
		$output = json_encode($finarray);
	}
}
js2php_proc();
?>




<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="apple-mobile-web-app-capable" content="yes">
<title>Overlay two images</title>
<link rel="stylesheet" href="OpenLayers-2.13.1/theme/default/style.css" type="text/css">
<link rel="stylesheet" href="OpenLayers-2.13.1/examples/style.css" type="text/css">
<style type="text/css">
p.caption {
width: 512px;
}
</style>
<script src="OpenLayers-2.13.1/lib/Firebug/firebug.js"></script>
<script src="OpenLayers-2.13.1/lib/OpenLayers.js"></script>
<script type="text/javascript">

var newArr = JSON.parse(sessionStorage.finarray);
var map;
function init(){
	map = new OpenLayers.Map('map');

	var bw1=0;	//base image coordinate xb1
	var bh1=0;	//base image coordinate yb1
	var bw2=0;	//base image coordinate xb2
	var bh2=0;	//base image coordinate yb2
	var sw1=0;	//sub image coordinate xs1
	var sh1=0;	//sub image coordinate ys1
	var sw2=0;	//sub image coordinate xs2
	var sh2=0;	//sub image coordinate ys2
	var bw=0;	//base image width = xb2 - xb1
	var bh=0;	//base image height = yb2 - yb1
	var sw=0;	//sub image width = xs2 - xs1
	var sh=0;	//sub image height = ys2 - ys1
	var siw=0;	//image width to be done = base image width / sub image width
	var sih=0;	//image height to be done = base image height / sub image height
	var iw=0;	//scaling of sub image width
	var ih=0;	//scaling of sub image height
	var si1=0;	//scaled image first coordinate of subimage width
	var si2=0;	//scaled image first coordinate of subimage height
	var d1 = 0;	//calculating the extreme left coordinate of the sub image
	var d2 = 0;	//calculating the extreme top coordinate of the subimage
	var d3 = 0;	//calculating the extreme right coordinate of the sub image
	var d4 = 0;	//calculating the extreme bottom coordinate of the sub image
	var d5 = 0;	//scaling to the correct left coordinate with respect to the base image
	var d6 = 0;	//scaling to the correct top coordinate with respect to the base image
	var d7 = 0;	//scaling to the correct right coordinate with respect to the base image
	var d8 = 0;	//scaling to the correct bottom coordinate with respect to the base image



	bw1 = newArr[0] + 0.001;
	bh1 = newArr[1] + 0.001;
	bw2 = newArr[2] + 0.001;
	bh2 = newArr[3] + 0.001;
	sw1 = newArr[4] + 0.001;
	sh1 = newArr[5] + 0.001;
	sw2 = newArr[6] + 0.001;
	sh2 = newArr[7] + 0.001;
	bw  = bw2 - bw1;
	bh  = bh2 - bh1;
	sw  = sw2 - sw1;
	sh  = sh2 - sh1;
	siw = bw/sw;
	sih = bh/sh;
	if(Math.abs(sh)<=2) {
                sih = 1;
        }
        if(Math.abs(sw)<=2) {
                siw = 1;
        }
	iw  = 980*siw;
	ih  = 500*sih;
	si1 = sw1*siw;
	si2 = sh1*sih;
	d1  = bw1 - si1;
	d2  = bh1 - si2;
	d3  = d1  + iw;
	d4  = d2  + ih;
	d5  = (320.00/980.00)*d1 - 160;
	d6  = (177.518/500.00)*d2 - 88.759;
	d7  = (320.00/980.00)*d3 - 160;
	d8  = (177.518/500.00)*d4 - 88.759;



	var x1 = d5;
	var y1 = d6;
	var y11 = 0;
	var y22 = 0;
	var x2 = d7;
	var y2 = d8;
	y11 = -1*y2;
	y22 = -1*y1;
	var boundingbox = new Array();
	boundingbox[0] = x1;
	boundingbox[1] = y11;
	boundingbox[2] = x2;
	boundingbox[3] = y22;
	boundingbox[4] = newArr[8];
	boundingbox[5] = newArr[9];
	var boundingbox1 = boundingbox;
	var graphic = new OpenLayers.Layer.Image(
			'Overlaid Image-I',
			newArr[9],
			new OpenLayers.Bounds(x1, y11, x2, y22),
			new OpenLayers.Size(300,150),
			{numZoomLevels: 3, isBaseLayer: false, opacity: 0.5}
			);

	graphic.events.on({
		loadstart: function() {
		OpenLayers.Console.log("loadstart");
	},
		loadend: function() {
			OpenLayers.Console.log("loadend");
		}
		});


var graphic1 = new OpenLayers.Layer.Image(
		'Base Image',
		newArr[8],
		new OpenLayers.Bounds(-160, -88.759, 160, 88.759),
		new OpenLayers.Size(980,500),
		{numZoomLevels: 3, isBaseLayer: true}
		);

graphic1.events.on({
loadstart: function() {
OpenLayers.Console.log("loadstart2");
},
loadend: function() {
OpenLayers.Console.log("loadend2");
}
});


var myarr = new Array();
myarr[0] = newArr[8];
myarr[1] = newArr[9];
var str = JSON.stringify(myarr);
sessionStorage.myarr = str;


var jpl_wms = new OpenLayers.Layer.WMS(
		"Global Imagery",
		"http://demo.opengeo.org/geoserver/wms",
		{layers: "bluemarble"},
		//{maxExtent: [-160, -88.759, 160, 88.759], numZoomLevels: 3}
		{numZoomLevels: 3}
		);

map.addLayers([graphic1, graphic]);
map.addControl(new OpenLayers.Control.LayerSwitcher());
map.zoomToMaxExtent();
	$.ajax({
		type: "POST",
		url: "finalresult.php",
		data: { name: boundingbox}
	})
	.done(function( msg ) {
		//document.getElementById("demo11").innerHTML = "Data Saved: " + msg ;
	});
	$.ajax({
		type: "POST",
		url: "allmaps.php",
		data: { name: boundingbox1}
	})
	.done(function( msg ) {
		//document.getElementById("demo11").innerHTML = "Data Saved: " + msg ;
	});
}
</script>
</head>
<body onload="init()">
<h1 id="title">Result on Overlay of images</h1>

<div id="tags">
image, imagelayer
</div>

<p id="shortdesc">
</p>

<div id="map" class="smallmap"></div>

<div id="docs">
<p class="caption">
</p>

</div>
</body>



<?php

try
{
	$a = new PharData('archive.tar');
	$myfile = fopen("presentfiles.txt","r");
	$line = array();
	$line[0] = fgets($myfile);
	$line[1] = fgets($myfile);
	$line[2] = fgets($myfile);
	$line[3] = fgets($myfile);
	$line[4] = fgets($myfile);
	$line[5] = fgets($myfile);
	fclose($myfile);
	/*$count = 0;
	while(!feof($myfile)) {
		$line[$count] = fgets($myfile);
		$count = $count + 1;
	}
	fclose($myfile);*/
	// ADD FILES TO archive.tar FILE
	$base = substr($line[4], 0, -1);
	$sub = substr($line[5], 0, -1);
	$a->addFile($base);
	$a->addFile($sub);
	//$a->addFile('data/base.png');
	//$a->addFile('data/sub0.png');
	$a->addFile('temp.html');
	$a->addFile('readme.txt');
} 
catch (Exception $e) 
{
    echo "Exception : " . $e;
}
?>
<p>You can download the files <b><a href="archive.tar">here</a></b> and can display on your website and do read how you can put it into your host address.</p>
<br>


<?php

try
{
        $a1 = new PharData('archiveall.tar');
        $myfile = fopen("dataimages.txt","r");
        $line = array();
        //$line[0] = fgets($myfile);
        //$line[1] = fgets($myfile);
        //fclose($myfile);
        $count = 0;
        while(!feof($myfile)) {
                $line[$count] = fgets($myfile);
		//echo $base;
                $count = $count + 1;
        }
        fclose($myfile);

	for ($i=0; $i<$count - 1; $i++) {
		$base = substr($line[$i], 0, -1);
		$a1->addFile($base);
	}
        // ADD FILES TO archive.tar FILE
        //$a->addFile($line[0]);
        //$a->addFile($line[1]);
        $a1->addFile('dimg.html');
        $a1->addFile('readme.txt');
}
catch (Exception $e)
{
    echo "Exception : " . $e;
}
?>
<p>You can download <b>all</b> the files <b><a href="archiveall.tar">here</a></b> and can display on your website and do read how you can put it into your host address.</p>
<br>




<p><b>Not satisfied with the results!!! Try again </b></p>
<form action="index.php" method="post">
<input type="hidden" name="state" id="state" value="collect" />
<input type="submit" value="Try again" />
</form>

<br>
<br>
<p>Want to add more different images!!! <a href="index.php">Add more images</a><p>

<p>Add more images to the exisitng base image<p>
<form action="index.php" method="post">
	<input type="hidden" name="state" id="state" value="getSub" />
	<input type="submit" value="Submit">
</form>



<?php
?>
</html>
