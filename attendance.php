<?php 
	include('check.php');
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
	<title>考勤单</title>

	  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="public/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
  <link href="public/css/init.css" rel="stylesheet" />

<script type="text/javascript" src="public/lib/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="public/bootstrap/js/bootstrap.min.js"></script>

</head>
<body>
attendance<br/>
<?php echo $_SESSION['uname'];?>
<div id="result"></div>
<script type="text/javascript">
	$('#result').text(navigator.userAgent);
</script>
</body>
</html>