<?php require_once ('../../share/myheader.php'); ?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Реєстрація</title>
	<link rel="stylesheet" type="text/css" href="../../share/share.css" />
	<link rel="stylesheet" type="text/css" href="../../index/index.css" />
	<link rel="shortcut icon" href="../../share/images/logo.png" type="image/x-icon">
</head>

<body>
<?php
// перевірка на вшивість юзера
require_once ('../../share/instruments.php');
userrights('admin');
// якщо юзер адмін то можна йти далі
require_once ('../../share/classdb.php');
require_once ('../../share/classuser.php');
if (!empty($_GET['uid']))
	{
		$myuser = new user();
		$myuser -> uid = $_GET['uid'];
		$lid = '?uid=' . $_GET['uid'];
		
		if (isset($_POST['submit']))
			if ((!empty($_POST['passw'])) && (!empty($_POST['passwconf'])))
				{
					if ($_POST['passw'] == $_POST['passwconf'])
						{
							$myuser -> changepassw($_POST['passw']);
							$host = $_SERVER['HTTP_HOST'];
							header("Location: http://$host/admin/groups/groups.php?inf=" . $_GET['uid']);
						}
					else
						myerror(' Поля не збігаються!');
				}
			else
				myerror(' Ви не заповнили всі поля!');
	}
?>
	<div id = "window">
		<p id="hi" style="left: 80px;">Зміна паролю</p>
		<!-- Обєкти вікна -->
		<table id="table">
			<tr>
				<td id="top"></td>
			</tr>
			<tr>
				<!--  -->
				<td id="page">
					<form action="./chpassw.php<?php echo $lid; ?>" method="POST">
					<table id="tablein">
						<tr><td><br/></td></tr>
						<tr><td>новий пароль:</td></tr>
						<tr><td><input type="password" class="instring" name="passw" /></td></tr>
						<tr><td>пароль ще раз:</td></tr>
						<tr><td><input type="password" class="instring" name="passwconf"/></td></tr>
						<tr>
							<td><input type="submit" name="submit" id="button" value="ок"/></td>
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
		<!-- /Обєкти вікна -->
	</div>

</body>

</html>