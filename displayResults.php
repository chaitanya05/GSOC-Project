<html>
<head>
<title>lol</title>
</head>
<body>
<script src="zoom/assets/jquery-1.7.1.min.js"></script>
<?php
function js2php_proc() {
	$str = json_decode($_POST['str'], true); 
	echo json_encode($str);
}
js2php_proc();
?>


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


<?php

$command1 = shell_exec(raster2pgsql -s 4326 -I -C -M?> <?php echo $base->url; ?> <?php -F -t 500x980 public.schema > elev-sample1.sql | psql -U postgres -d demo -f elev-sample1.sql);
if(!$command1) {
	echo "Upload error!";
}


$dbconn=pg_connect("dbname=demo user=user password=user");

if(!$dbconn) {
        echo "Error connecting to the database!<br> " ;
        printf("%s", pg_errormessage($dbconn));
        exit();
}
else {
        echo "connected", "\n";
}

$result = pg_query($dbconn, "SELECT * FROM demo");
if(!$result) {
	echo "An error occured.\n";
	exit();
}
else {
	        //echo $result;
}

while ($row = pg_fetch_row($result)) {
        echo "value1: $row[0]  value2: $row[1] value3: $row[2]";
        echo "<br />\n";
}


?>
</body>
</html>
