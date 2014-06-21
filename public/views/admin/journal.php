<?php
require_once('../../../private/Controllers/JournalController.php');
require_once('../header.php');
?>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Адміністрування груп</title>
	<link rel="stylesheet" type="text/css" href="../../styles/share.css" />
	<link rel="stylesheet" type="text/css" href="../../styles/journal.css" />
	<link rel="shortcut icon" href="../../styles/share/logo.png" type="image/x-icon">
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

			<p id="bookmark1"><a href="./reg/group_new.php">Додати групу</a></p>		<!-- закладка1 -->
			<p id="bookmark2"><a href="./reg/user_new.php">Додати корист.</a></p>	<!-- закладка2 -->
			<p id="bookmark3"><a href="<?php echo $_SERVER['PHP_SELF']; ?>">Форзац</a></p>							<!-- закладка3 -->
	
	<p class="mend"><a href="../admin.php">На головну</a></p>
	<?php $mybook -> myerror(); ?>
	<p id="bottom"></p>
</body>
</html>