<?php
require_once("../private/Controllers/LoginController.php");
require_once("./views/header.php");
?>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Вітання</title>
	<link rel="stylesheet" type="text/css" href="./styles/share.css" />
	<link rel="stylesheet" type="text/css" href="./styles/index.css" />
	<link rel="shortcut icon" href="./styles/share/logo.png" type="image/x-icon">
</head>

<body>

	<div id = "window">
		<p id="hi">Вхід</p>

	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
		<table id="tablein">
			<tr><td><br/></td></tr>
			<tr><td>логін:</td></tr>
			<tr>
				<td><input type="text" class="instring" name="user" value="<?php echo $user; ?>" /></td></tr>
			</tr>
			<tr><td>пароль:</td></tr>
			<tr>
				<td><input type="password" class="instring" name="pass"/></td></tr>
			</tr>
			<tr>
				<td><input type="submit" name="enter" id="button" value="ок"/></td>
			</tr>
		</table>

	</div>

<?php errors(); ?>

</body>
</html>