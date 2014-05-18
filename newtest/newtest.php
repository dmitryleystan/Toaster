<?php require_once('./processing.php') ?>
 
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Питання № <?php echo $number; ?></title>
	<link rel="stylesheet" type="text/css" href="./newtest.css" />
	<link rel="shortcut icon" href="../share/images/logo.png" type="image/x-icon">

	
</head>

<body>


<p id="user"><?php echo $_SESSION['nick'] ?></p>
<div id="surface">
	<p id="first">Питання № <?php echo $number; ?> </p>
	<form action="<?php echo $_SERVER['PHP_SELF']; $number++; echo "?number=$number&sub=$name&id=$id&answ=$last"; ?>" method="POST">

		<p><textarea style="width: 1000px; height: 80px; position: relative; left: -250px;" name="question"></textarea></p>
		<div id="content">

			<div id="center">
				<p class="myh"><input type="radio" name="type" value="comlicated" /><br/>Відповідність</p> 
				<div id = "compl">
					<input type="button" value="-" onClick="delPrev('vidl');" style="width: 25px;" />
					<input type="button" value="+" onClick="addNext('compl','vidl');" style="width: 25px;" />
					<input type="text" name="vidl0" id="vidl0" value="" size="25" style="width: 170px;" />

				</div>

				<div id = "compr">
					<input type="button" value="-" onClick="delPrev('vidr');" style="width: 25px;" />
					<input type="button" value="+" onClick="addNext('compr','vidr');" style="width: 25px;" />
					<input type="text" name="vidr0" id="vidr0" value="" size="25" style="width: 170px;" />
				</div>
			</div>

			<div id="pleft">
				<p class="myh"><input type="radio" name="type" value="logical" /><br/>Лоігчне</p>
				
					<table style="margin-bottom: 20px; position: relative; left: 40px;">
							<tr><td><input type="radio" name="logical" value=0 checked="true"/> ні</td></tr>
							<tr><td><input type="radio" name="logical" value=1 /> так</td></tr>
					</table>
			</div>

			<div id="pright">
				<p class="myh"><input type="radio" name="type" value="typical" checked="true" /><br/>Звичайне</p>
				<input type="button" value="-" onClick="delPrev('std');" style="width: 25px;" />
				<input type="button" value="+" onClick="addNext('pright','std');" style="width: 25px;" />
				<div>
					<input type="checkbox" id="stch0" name="stch[]" value="0" />
					<input type="text" name="std0" id="std0" value="" size="25" style="width: 160px;" />
				</div>
			</div>

		</div>
		<div id="buttons">
			<input type="submit" name="next" class="button" value="Наступне"/>
		</div>
	</form>
	<p id = "end"><a href="../admin/admin.php">Закінчити</a></p>
	

	<div id="exit">
		<a href="../share/logout.php"><img src="../share/images/exit.gif" style="width: 50px;" /></a>
	</div>
	<p id="bottom"></p>
</div>

<?php
mysql_close($db);
?>
</body>