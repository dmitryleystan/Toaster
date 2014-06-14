<?php
require_once ('../../share/header.php');
require_once ('../../share/RightsValidation.php');
userrights('admin');
	require_once('../../share/DataBaseClass.php');
	require_once('../../share/classtest.php');
	require_once('../../share/classuser.php');
	require_once('../../share/classgroup.php');
	require_once('../../share/classbook.php');
require_once('./processing.php');
?>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Адміністрування груп</title>
	<link rel="stylesheet" type="text/css" href="../../share/share.css" />
	<link rel="stylesheet" type="text/css" href="./group.css" />
	<link rel="shortcut icon" href="../../share/images/logo.png" type="image/x-icon">
</head>

<body>
	<div id="book">

	<form action= "<?php echo $_SERVER['PHP_SELF']; echo $lid; ?>" method="POST"> <!-- книжечка -->

		<!-- ліва сторінка -->
		<div id="leftpage">
			<?php
				$mybook -> showleftpage($aboutl, $l);
			?>
		</div>

		<!-- права сторінка -->
		<div id="rightpage">
			<?php
				$mybook -> showrightpage($aboutr, $r);
			?>
		</div>

			<?php
				if (isset($_POST['delgroup']))
						$mybook -> deletention();
			?>
	</form>
	</div> <!-- кінець книжечки -->

			<p id="bookmark1"><a href="<?php echo "http://$host"; ?>/reg/newgroup/reg.php">Додати групу</a></p>		<!-- закладка1 -->
			<p id="bookmark2"><a href="<?php echo "http://$host"; ?>/reg/newuser/reg.php">Додати корист.</a></p>	<!-- закладка2 -->
			<p id="bookmark3"><a href="<?php echo $_SERVER['PHP_SELF']; ?>">Форзац</a></p>							<!-- закладка3 -->
	
	<p class="mend"><a href="../admin.php">На головну</a></p>
	<?php $mybook -> myerror(); ?>
	<p id="bottom"></p>
</body>
<?php 
$mybook -> close();
$mygroup -> close();
?>
</html>