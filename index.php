<?php
require_once ('./share/myheader.php');
?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Вітання</title>
	<link rel="stylesheet" type="text/css" href="../share/share.css" />
	<link rel="stylesheet" type="text/css" href="./index/index.css" /> 
	<link rel="shortcut icon" href="./share/images/logo.png" type="image/x-icon">
</head>

<body>

<?php
// можливо є пєчєнька?
$host = $_SERVER['HTTP_HOST'];
session_start();
require_once ('./share/instruments.php');
if (!empty($_SESSION['rights']))
		if ($_SESSION['rights'] == 'admins')
			header("Location: http://$host/admin/admin.php");
		else
			header("Location: http://$host/user/user.php");
// перевірив чи це друга ітерація(чи була вже нажата кнопка)
if (isset($_POST['mysubmit']))
	{
		$user = $_POST['user'];
		$pass = $_POST['pass'];
// 		// якщо це спроба входу я перевіряю отримані дані
		if ((empty($user)) || (empty($pass)))
			myerror('забули ввести логін/пароль!');
		else
		{
		// вхожу
			require_once('./share/classdb.php');
			$mydb = new database('ross','sunshine');
			// шукаю таких юзерів
			$query = "SELECT * FROM users WHERE name = '$user'";
			$result = $mydb -> selectdata($query);	

			while ($str = mysql_fetch_array($result, MYSQLI_NUM))
						{
						// якщо паролі збігаються
						if (($str[1]==$user) && ($str[2]==$pass))
							{
								mysql_free_result($result);
								mysql_close($db);
								$_SESSION['nick'] = $str[1];
								$_SESSION['rights'] = $str[3];

								if ($str[3] == "admins")
									{
										header("Location: http://$host/admin/admin.php?un=$user");
									} 
									else
										header("Location: http://$host/user/user.php?un=$user");
							}
						}
				
		mysql_free_result($result);
		$mydb -> close();
		myerror(' невірний логін/пароль!');
		}
	}
?>

	<div id = "window">
		<p id="hi">Вхід</p>
		<!-- Обєкти вікна -->
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
				<td><input type="submit" name="mysubmit" id="button" value="ок"/></td>
			</tr>
		</table>
		<!-- /Обєкти вікна -->
	</div>

</body>
</html>