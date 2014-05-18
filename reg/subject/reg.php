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
if (isset($_POST['submit']))
	{
		// перевірив чи це друга ітерація(чи була вже нажата кнопка)
		$subname = $_POST['subname'];
		$host = $_SERVER['HTTP_HOST'];
		$find = 1;
		// фінальна перевірка введених даних 
		if (!empty($subname))
			{
					require_once('../../share/classdb.php');
				// перевіряю на наявність ідентичного предмету
				$mydb = new database('ross','sunshine');
				$query = "SELECT sname FROM subjects WHERE sname LIKE '$subname'";
				$result = $mydb -> selectdata($query);
				while ($str = mysql_fetch_array($result, MYSQLI_NUM))
					if ($subname == $str[0])
							$find = 0;	

				//
				if ($find == 1) // якщо такого предмету немає я його реєструю
					{
						$query = "INSERT INTO subjects (sname) VALUES ('$subname')";
						$mydb -> insertdata($query);
						header("Location: http://$host/admin/admin.php?ok=1");
					}
				else
					myerror(' такий предмет вже існує!');
			}	
		else
			myerror(' Введіть назву нового предмету!');
	}
?>
	<div id = "window">
		<p id="hi" style="left: 70px;">Новий предмет</p>
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
							<td height="50">Ім'я нового предмету:</td>
						</tr>
						<tr>
							<td><input type="text" class="instring" name="subname" value="<?php echo $subname; ?>"></td>
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
