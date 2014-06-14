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
		$groupname = $_POST['groupname'];
		$host = $_SERVER['HTTP_HOST'];
		$find = 1;
		// фінальна перевірка введених даних
		if (!empty($groupname))
			{
					require_once('../../share/DataBaseClass.php');
				// перевіряю на наявність ідентичної групи
				$mydb = new database('ross','sunshine');
				$query = "SELECT name FROM groups WHERE name LIKE '$groupname'";
				$result = $mydb -> selectdata($query);
				while ($str = mysql_fetch_array($result, MYSQLI_NUM))
				{
					if ($groupname == $str[0])
							$find = 0;	
				}

				//
				if ($find == 1) // якщо такої групи немає я її реєструю
					{
						$query = "INSERT INTO groups (name) VALUES ('$groupname')";
						$mydb -> insertdata($query);
						header("Location: http://$host/admin/groups/groups.php?ok=1");
					}
				else
					myerror(' така група вже існує!');
			}	
		else
			myerror(' Введіть назву нової групи!');
	}
?>
	<div id = "window">
		<p id="hi" style="left: 90px;">Нова група</p>
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
						<tr>
							<td height="50">Ім'я нової групи:</td>
						</tr>
						<tr>
							<td><input type="text" class="instring" name="groupname" value="<?php echo $groupname; ?>"></td>
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
