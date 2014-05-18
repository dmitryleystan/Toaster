<?php
require_once ('./processing.php');
?>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Кабінет користувача</title>
	<link rel="stylesheet" type="text/css" href="../share/share.css" />
	<link rel="stylesheet" type="text/css" href="./user.css" />
	<link rel="shortcut icon" href="../share/images/logo.png" type="image/x-icon">

</head>

<body>

<?php
require_once ('../share/instruments.php');
userrights('user');
?>

<p id="user"><?php echo $q; ?></p>

<div id="content">
	<p id="first">Ласкаво просимо</p>
	<div id="center">
		<div id="left">
			<p class="second">Особисті дані</p>
			<?php
				showinfo();
			?>
		</div>
		<div id="right">
			<p class="second">Останні результати</p>
			<?php 
				$myuser -> showmarks();
			?>
		</div>
	</div>
</div>


<div id="exit">
	<a href="../share/logout.php"><img src="../share/images/exit.gif" style="width: 50px;" /></a>
</div>
<p id="bottom"></p>
</body>
<?php $myuser -> close(); ?>
</html>