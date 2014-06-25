<?php
require_once('../../../../private/Controllers/RegController.php');
require_once('../../header.php');
?>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Вага відповідей</title>
    <link rel="stylesheet" type="text/css" href="../../../styles/share.css" />
    <link rel="stylesheet" type="text/css" href="../../../styles/index.css" />
    <link rel="shortcut icon" href="../../../styles/share/logo.png" type="image/x-icon">
</head>

<body>
	<div id = "window">
		<p id="hi" style="left: 70px; top: 20px;">Вага відповідей</p>

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
						<tr><td><input type="text" class="instring" name="cost1" value="<?php echo $tar[0]; ?>"></td>
						</tr>
						<tr><td>звичайне:</td></tr>
						<tr><td><input type="text" class="instring" name="cost2" value="<?php echo $tar[1]; ?>"/></td>
						</tr>
						<tr><td>на відповідність:</td></tr>
						<tr><td><input type="text" class="instring" name="cost3" value="<?php echo $tar[2]; ?>"/></td>
						</tr>
						<tr>
							<td><input type="submit" name="ch_tar" id="button" value="ок"/></td>
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

</body>

</html>
