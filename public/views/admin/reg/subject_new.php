<?php
require_once('../../../../private/Controllers/RegController.php');
require_once('../../header.php');
?>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Новий предмет</title>
    <link rel="stylesheet" type="text/css" href="../../../styles/share.css" />
    <link rel="stylesheet" type="text/css" href="../../../styles/index.css" />
    <link rel="shortcut icon" href="../../../styles/share/logo.png" type="image/x-icon">
</head>

<body>
	<div id = "window">
		<p id="hi" style="left: 70px;">Новий предмет</p>

		<table id="table">
			<tr>
				<td id="top"></td>
			</tr>
			<tr>
				<!--  -->
				<td id="page">
					<form action="./subject_new.php" method="POST">
					<table id="tablein">
						<tr><td><br/></td></tr>
						<tr>
							<td height="50">Ім'я нового предмету:</td>
						</tr>
						<tr>
							<td><input type="text" class="instring" name="subname" value="<?php echo $subname; ?>"></td>
						</tr>	
						<tr>
							<td><input type="submit" name="newsub" id="button" value="ок"/></td>
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
