<?php
require_once('../../../private/Controllers/TestPassController.php');
require_once('../header.php');
?>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title><?php  ?></title>
    <link rel="stylesheet" type="text/css" href="../../styles/share.css" />
    <link rel="stylesheet" type="text/css" href="../../styles/user.css" />
    <link rel="shortcut icon" href="../../styles/share/logo.png" type="image/x-icon">

</head>

<body>

<p id="user"><?php echo $q; ?></p>
<form action="<?php echo $_SERVER['PHP_SELF']; $number++; echo "?n=$number&qid=$qid&id=$id"; ?>" method="POST">
	<div id="content">
		<p id="first">Питання №<?php echo $number;?></p>
		<div id="center">
			<div id="question">
			<p style="margin: 5px;"><?php echo $condition[1]; ?></p>
			</div>
			<?php
				showquestion();
			?>
		</div>
		<div style="width: 300px;">
			<input type="submit" name="next" value="Наступне" style="position: relative; left: 720px;" />
		</div>
	</div>
</form>
<div id="mend"><a href="index.php">На головну</a></p></div>
<div id="exit">
	<a href="../share/logout.php"><img src="../share/images/exit.gif" style="width: 50px;" /></a>
</div>

<p id="bottom"></p>
</body>
<?php $myuser -> close(); ?>
</html>