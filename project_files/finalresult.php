<?php
$cosmo = $_POST["name"];
if($_POST['name']) {
	echo $cosmo[0];
	echo $cosmo[1];
	echo $cosmo[2];
	echo $cosmo[3];
}

$myfile = fopen("temp.html", "w");


fwrite($myfile, "<html>\n");
fwrite($myfile, "<head>\n");
fwrite($myfile, "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\n");
fwrite($myfile, "		<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0\">\n");
fwrite($myfile, "		<meta name=\"apple-mobile-web-app-capable\" content=\"yes\">\n");
fwrite($myfile, "		<title>Overlay two images</title>\n
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
map = new OpenLayers.Map('map');\n
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
map.addControl(new OpenLayers.Control.LayerSwitcher());
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


fclose($myfile);

?>
