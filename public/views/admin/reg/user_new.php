<?php
require_once('../../../../private/Controllers/RegController.php');
require_once('../../header.php');
?>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Реєстрація</title>
	<link rel="stylesheet" type="text/css" href="../../../styles/share.css" />
	<link rel="stylesheet" type="text/css" href="../../../styles/index.css" />
	<link rel="shortcut icon" href="../../../styles/share/logo.png" type="image/x-icon">
</head>

<body>

	<div id = "window">
		<p id="hi" style="left: 90px;">Реєстрація</p>

		<table id="table">
			<tr>
				<td id="top"></td>
			</tr>
			<tr>
				<!--  -->
				<td id="page">
					<form action="./user_new.php" method="POST">
					<table id="tablein">
						<tr><td><br/></td></tr>
						<tr><td>логін:</td></tr>
						<tr><td><input type="text" class="instring" name="user" value="<?php echo $user; ?>"></td></tr>
						</tr>
						<tr><td>пароль:</td></tr>
						<tr><td><input type="password" class="instring" name="pass"/></td></tr>
						</tr>
						<tr>
                            <td>
							<input type="checkbox" name="rights" value="Yes"/><span>Адмін?</span>
						    </td>
                        </tr>
						<tr>
							<td><input type="submit" name="newuser" id="button" value="ок"/></td>
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
