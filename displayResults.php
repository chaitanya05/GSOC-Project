<html>
<head>
<title>lol</title>
</head>
<body>
<?php
function js2php_proc() {
	$str = json_decode($_POST['str'], true); 
	echo json_encode($str);
}
?>
</body>
</html>
