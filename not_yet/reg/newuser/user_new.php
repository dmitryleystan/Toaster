<?php require_once ('../../share/header.php'); ?>
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
require_once ('../../share/RightsValidation.php');
userrights('admin');
// якщо юзер адмін то можна йти далі
if (isset($_POST['submit']))
	{
		// перевірив чи це друга ітерація(чи була вже нажата кнопка)
		$user = $_POST['user'];
		$pass = $_POST['pass'];
		$rights = $_POST['rights'];
		$host = $_SERVER['HTTP_HOST'];
		$find = 1;
		// фінальна перевірка введених даних + надання прав користувачу
		if (!(empty($user) || empty($pass)))
			{
				if ($rights == 'Yes')
						$right = "admins";
					else
						$right = "users";	

					require_once('../../share/DataBaseClass.php');
				// перевіряю на наявність ідентичного юзера
				$mydb = new database('ross','sunshine');
				$query = "SELECT * FROM users WHERE name LIKE '$user'";
				$result = $mydb -> selectdata($query);
				while ($str = mysql_fetch_array($result, MYSQLI_NUM))
				{
					if ($user == $str[1])
							$find = 0;	
				}

				//
				if ($find == 1) // якщо такого юзера немає я його реєструю
					{
						$query = "INSERT INTO users (name, password, ugroup) VALUES('$user', '$pass', '$right')";
						$mydb -> insertdata($query);
						header("Location: http://$host/admin/groups/groups.php");
					}
				else
					myerror(' такий користувач вже існує!');
			}	
		else
			myerror(' забули ввести логін/пароль!');

	}
?>
	<div id = "window">
		<p id="hi" style="left: 90px;">Реєстрація</p>
		<!-- Обєкти вікна -->
		<table id="table">
			<tr>
				<td id="top"></td>
			</tr>
			<tr>
				<!--  -->
				<td id="page">
					<form action="./reg.php" method="POST">
					<table id="tablein">
						<tr><td><br/></td></tr>
						<tr><td>логін:</td></tr>
						<tr><td><input type="text" class="instring" name="user" value="<?php echo $user; ?>"></td></tr>
						</tr>
						<tr><td>пароль:</td></tr>
						<tr><td><input type="password" class="instring" name="pass"/></td></tr>
						</tr>
						</tr>
						<tr><td>
							<input type="checkbox" name="rights" value="Yes"/><span>Адмін?</span>
						</td></tr>
						</tr>
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
