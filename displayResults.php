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

<?php

$dbconn=pg_connect("dbname=demo user=user password=user");

if(!$dbconn) {
        echo "Error connecting to the database!<br> " ;
        printf("%s", pg_errormessage($dbconn));
        exit();
}
else {
        echo "connected", "\n";
}

$sqlcom="select * from demo";
$dbres = pg_exec($dbconn, $sqlcom);
if(!$dbres) {
        echo "Error : " + pg_errormessage($dbconn);
        exit();
}
else {
        printf("%s\n", $dbres);
}

$do = pg_Fetch_Object($dbres, 2);
$name= $do->name;
echo "and the name is... $name\n";


?>
</body>
</html>
