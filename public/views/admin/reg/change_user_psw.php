<?php
require_once('../../../../private/Controllers/RegController.php');
require_once('../../header.php');
?>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Змінити пароль</title>
    <link rel="stylesheet" type="text/css" href="../../../styles/share.css" />
    <link rel="stylesheet" type="text/css" href="../../../styles/index.css" />
    <link rel="shortcut icon" href="../../../styles/share/logo.png" type="image/x-icon">
</head>

<body>
	<div id = "window">
		<p id="hi" style="left: 80px;">Зміна паролю</p>

		<table id="table">
			<tr>
				<td id="top"></td>
			</tr>
			<tr>
				<!--  -->
				<td id="page">
					<form action="./change_user_psw.php<?php echo $lid; ?>" method="POST">
					<table id="tablein">
						<tr><td><br/></td></tr>
						<tr><td>новий пароль:</td></tr>
						<tr><td><input type="password" class="instring" name="passw" /></td></tr>
						<tr><td>пароль ще раз:</td></tr>
						<tr><td><input type="password" class="instring" name="passwconf"/></td></tr>
						<tr>
							<td><input type="submit" name="chpasswd" id="button" value="ок"/></td>
						</tr>
					</table>
					</form>
				</td>
				<!--  -->
			</tr>
			<tr>
				<td id="bottom"></td>
			</tr>
		</table>

	</div>
<?php
if ($error_string != "")
    myerror($error_string);
?>
</body>

</html>