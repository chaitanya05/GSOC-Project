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
</body>
</html>
