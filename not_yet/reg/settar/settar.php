<?php require_once ('../../share/header.php'); ?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Вага відповідей</title>
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
require_once('../../share/DataBaseClass.php');
require_once('../../share/classtest.php');
$mytest = new test();
$tid = $_GET['tid'];
$mytest -> tid = $_GET['tid'];
if (isset($_POST['submit']))
	{
		$tar = array($_POST['cost1'], $_POST['cost2'], $_POST['cost3']);
		$mytest -> settar($tar);
		header("Location: http://$host/admin/admin.php?ok=1");
	}
$tar = $mytest -> gettar();
?>
	<div id = "window">
		<p id="hi" style="left: 70px; top: 20px;">Вага відповідей</p>
		<!-- Обєкти вікна -->
		<table id="table">
			<tr>
				<td id="top"></td>
			</tr>
			<tr>
				<!--  -->
				<td id="page">
					<form action="<?php echo $_SERVER['PHP_SELF'] . '?tid=' . $tid; ?>" method="POST">
					<table id="tablein">
						<tr><td>логічне:</td></tr>
						<tr><td><input type="text" class="instring" name="cost1" value="<?php echo $tar[0]; ?>"></td></tr>
						</tr>
						<tr><td>звичайне:</td></tr>
						<tr><td><input type="text" class="instring" name="cost2" value="<?php echo $tar[1]; ?>"/></td></tr>
						</tr>
						</tr>
						<tr><td>на відповідність:</td></tr>
						<tr><td><input type="text" class="instring" name="cost3" value="<?php echo $tar[2]; ?>"/></td></tr>
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
