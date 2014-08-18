<?php

$myfilex1 = fopen("presentfiles.txt","r");
$cosmo = array();
$my1xcount = 0;
while(!feof($myfilex1)) {
	$cosmo[$my1xcount] = fgets($myfilex1);
	$my1xcount = $my1xcount + 1;
}
fclose($myfilex1);
/*$cosmo = $_POST["name"];
if($_POST['name']) {
        echo $cosmo[0];
        echo $cosmo[1];
        echo $cosmo[2];
        echo $cosmo[3];
}*/

$myfile1 = fopen("dataimages.txt","r");
$line = array();
$count = 0;
$splcare = 0;
$splcval = 0;

while(!feof($myfile1)) {
	$line[$count] = fgets($myfile1);
	if($line[$count] == $cosmo[5]) {
		$splcase = 1;
		$splcval = $count;
	}
	$count = $count + 1;
}
fclose($myfile1);

$typefile = substr($line[0],-4);
$nextimgcount = $count - 2;
$nextimg = "data/sub" .$nextimgcount. "." .$typefile. "";
//echo $nextimg;
//echo $cosmo[5];
$countx1 = $count - 1;
//echo $countx1;
//echo $line[$count - 1];
//echo $countx1;
//echo $splcase;
//echo $splcval;
//echo $count;

/*for( $p1 = 0; $p1 < $count; $p1++) {
	echo $line[$p1];
}*/


//echo $cosmo[0];
//echo $cosmo[1];
//echo $cosmo[2];
//echo $cosmo[3];
//echo "1-" .$cosmo[4]. "";
//echo "2-" .$line[0]. "";
if($cosmo[4]==$line[0]) {
	//if($cosmo[5]==$line[$countx1]) {}
	if($splcase == 1 && ($splcval + 2) == $count) {
		//echo "1st It enrtered here";
		$myfile2 = fopen("datacoordinates.txt","r");
		$line2 = array();
		$count2 = 0;
		while(!feof($myfile2)) {
			$line2[$count2] = fgets($myfile2);
			$count2 = $count2 + 1;
		}
		fclose($myfile2);
		$i = 0;
		$myfile3 = fopen("datacoordinates.txt","w");
		$line3 = array();
		$count3 = 0;
		$countx2 = $count2 - 1;
		for( $i=0; $i<$countx2 ; $i++){
			fwrite($myfile3,$line2[$i]);
		}
		$finaltxt = "" .$cosmo[0]. ", " .$cosmo[1]. ", " .$cosmo[2]. ", " .$cosmo[3]. "";
		fwrite($myfile3, $finaltxt);
		fclose($myfile3);
	}
	else if($cosmo[5]==$nextimg){
		//echo "oh my goodness!!!";
		$myfile1 = fopen("dataimages.txt","a");
		fwrite($myfile1, $cosmo[5]);
		fclose($myfile1);
		$myfile3 = fopen("datacoordinates.txt","a");
		$finaltxt = "" .$cosmo[0]. ", " .$cosmo[1]. ", " .$cosmo[2]. ", " .$cosmo[3]. "";
		fwrite($myfile3, $finaltxt);
		fclose($myfile3);
	}
	else {
		//echo "It enrtered here";
		$myfile1 = fopen("dataimages.txt","w");
		fwrite($myfile1, $cosmo[4]);
		fwrite($myfile1, $cosmo[5]);
		fclose($myfile1);
		$myfile3 = fopen("datacoordinates.txt","w");
		$finaltxt = "-160, -88.759, 160, 88.759\n";
		fwrite($myfile3, $finaltxt);
		$finaltxt = "" .$cosmo[0]. ", " .$cosmo[1]. ", " .$cosmo[2]. ", " .$cosmo[3]. "";
		fwrite($myfile3, $finaltxt);
		fclose($myfile3);	
	}
}
else {
	//echo "oops!! It enrtered here";
	$myfile1 = fopen("dataimages.txt","w");
	fwrite($myfile1, $cosmo[4]);
	fwrite($myfile1, $cosmo[5]);
	fclose($myfile1);
	$myfile3 = fopen("datacoordinates.txt","w");
	$finaltxt = "-160, -88.759, 160, 88.759\n";
	fwrite($myfile3, $finaltxt);
	$finaltxt = "" .$cosmo[0]. ", " .$cosmo[1]. ", " .$cosmo[2]. ", " .$cosmo[3]. "";
	fwrite($myfile3, $finaltxt);
	fclose($myfile3);
}








$graphic2 = array();
$line2 = array();
$line3 = array();
$i = 0;

$myfile4 = fopen("dataimages.txt","r");
$count4 = 0;
//echo "aaaa\n\n";
while(!feof($myfile4)) {
	$line2[$count4] = fgets($myfile4);
	$line2[$count4] = substr($line2[$count4], 0, -1);
	$count4 = $count4 + 1;
}

//echo $line2[0];
//echo $line2[1];
//substr(, 0, -1);


$myfile5 = fopen("datacoordinates.txt","r");
$count5 = 0;
while(!feof($myfile5)) {
	$line3[$count5] = fgets($myfile5);
	$count5 = $count5 + 1;
}


/*$subimgco = 0;
$subimgco = explode(",", $line3);*/

//echo "This is what it shouls print" .$count4. ";";

for( $i=1; $i<$count4 ; $i++ ) {
	$pix1 = $i - 1;
	$graphic2[$i] = "new OpenLayers.Layer.Image(\n 'Overlaid Image-" .$i. "',\n'" .$line2[$i]. "',\nnew OpenLayers.Bounds("
	. $line3[($pix1)*4 + 1].  "" .$line3[($pix1)*4+2]. "" .$line3[($pix1)*4+3]. "" .$line3[($pix1)*4+4]."),\n new OpenLayers.Size(980,500),\n {numZoomLevels: 3, isBaseLayer: false, opacity: 0.5}\n);";
}

//echo $line3[1];

/*for( $i=1; $i<$count4 ; $i++ ) {
	$graphic2[$i] = "new OpenLayers.Layer.Image(\n 'Overlaid Image-" .$i. "',\n'" .$line2[$i]. "',\nnew OpenLayers.Bounds(" .$line3[$i]. "),\n new OpenLayers.Size(980,500),\n {numZoomLevels: 3, isBaseLayer: false, opacity: 0.5}\n);";
}*/


/*$graphic2[0] = "new OpenLayers.Layer.Image(\n 'Base Image',\n'" .$line2[0]. "',\nnew OpenLayers.Bounds("
	. $subimgco[0].  ", " .$subimgco[1]. ", " .$subimgco[2]. ", " .$subimgco[3]."),\n new OpenLayers.Size(980,500),\n {numZoomLevels: 3, isBaseLayer: true}\n);";*/


$graphic2[0] = "new OpenLayers.Layer.Image(\n 'Base Image',\n'" .$line2[0]. "',\nnew OpenLayers.Bounds(" .$line3[0]. "),\n new OpenLayers.Size(980,500),\n {numZoomLevels: 3, isBaseLayer: true}\n);";


$myfile3 = fopen("dimg.html", "w");




fwrite($myfile3, "<html>\n");
fwrite($myfile3, "<head>\n");
fwrite($myfile3, "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\n");
fwrite($myfile3, "		<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0\">\n");
fwrite($myfile3, "		<meta name=\"apple-mobile-web-app-capable\" content=\"yes\">\n");
fwrite($myfile3, "		<title>Overlay two images</title>\n
		<link rel=\"stylesheet\" href=\"OpenLayers-2.13.1/theme/default/style.css\" type=\"text/css\">\n
		<link rel=\"stylesheet\" href=\"OpenLayers-2.13.1/examples/style.css\" type=\"text/css\">\n
		<style type=\"text/css\">\n
		p.caption {\n
width: 512px;\n
}\n
</style>\n
<script src=\"OpenLayers-2.13.1/lib/Firebug/firebug.js\"></script>\n
<script src=\"OpenLayers-2.13.1/lib/OpenLayers.js\"></script>\n
<script type=\"text/javascript\">\n

var map;\n
function init(){\n
map = new OpenLayers.Map('map');\n");

fwrite($myfile3, "var graphic3 = new Array();\n");

$j = 0;
$count7 = $count4 - 1;
for( $j=1 ; $j<$count7; $j++) {
	fwrite($myfile3, "graphic3[" .$j. "] = " .$graphic2[$j]. "\n");
}
fwrite($myfile3, "graphic3[0] = " .$graphic2[0]. "\nmap.addLayers([");


$count7 = $count4 - 2;
for( $j=0; $j<$count7; $j++ ) {
	fwrite($myfile3, "graphic3[" .$j. "], ");
}
fwrite($myfile3, "graphic3[" .$count7. "]]);\n");

/*
\n
var graphic = new OpenLayers.Layer.Image(\n
		'Overlaid Image-I',
		'".$cosmo[5]. "',
		new OpenLayers.Bounds(" .$cosmo[0]. "," .$cosmo[1]. "," .$cosmo[2]. "," .$cosmo[3]. "),
		new OpenLayers.Size(300,150),
		{numZoomLevels: 3, isBaseLayer: false, opacity: 0.5}
		);

graphic.events.on({
loadstart: function() {
OpenLayers.Console.log(\"loadstart\");
},
loadend: function() {
OpenLayers.Console.log(\"loadend\");
}
});


var graphic1 = new OpenLayers.Layer.Image(
		'Base Image',
		'" .$cosmo[4]. "',
		new OpenLayers.Bounds(-160, -88.759, 160, 88.759),
		new OpenLayers.Size(980,500),
		{numZoomLevels: 3, isBaseLayer: true}
		);

graphic1.events.on({
loadstart: function() {
OpenLayers.Console.log(\"loadstart2\");
},
loadend: function() {
OpenLayers.Console.log(\"loadend2\");
}
});



map.addLayers([graphic1, graphic]);
*/
fwrite($myfile3,
"map.addControl(new OpenLayers.Control.LayerSwitcher());
map.zoomToMaxExtent();
}
</script>
</head>
<body onload=\"init()\">
<h1 id=\"title\">Result on Overlay of images</h1>

<div id=\"tags\">
image, imagelayer
</div>

<p id=\"shortdesc\">
</p>

<div id=\"map\" class=\"smallmap\"></div>

<div id=\"docs\">
<p class=\"caption\">
	</p>

	</div>
	</body>
	</html>
	");



?>
