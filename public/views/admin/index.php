<?php
require_once('../../../private/Controllers/AdminController.php');
require_once('../header.php');
?>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Кабінет адміністратора</title>
	<link rel="stylesheet" type="text/css" href="../../styles/share.css" />
	<link rel="stylesheet" type="text/css" href="../../styles/admin.css" />
	<link rel="shortcut icon" href="../../styles/share/logo.png" type="image/x-icon">
</head>

<body id="abody">

<?php
//require_once ('./ResultsController.php');             What a ... ?!?!
//?>

<p id="reg"><a href="./groups/groups.php">Групи & Користувачі</a></p>
<p id="user"><?php echo $_SESSION['nick'] ?></p>
<div id="surface">
	<p id="first">Ласкаво просимо</p>
	<div id="content">
		<div id="center">
			<p class="myh">Знайти існуючий тест</p>
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
				<p>Відомі дані для пошуку:</p>
				<table id="myform">
				<col width="210">
					<tr>
						<td>Оберіть предмет:</td>
						<td>
							<select name="subject"  class="selectof" >
								<option value=0 selected="selected">...</option>
							<?php
								show_sub_list();
							?>
							</select>
						</td>
					</tr>
					<tr>
						<td>Введіть тему:</td>
						<td><input type="text" class="instring" name="ftheme"/></td>
					</tr>
					<tr>
						<td>Введіть групу:</td>
						<td>
							<input type="text"  class="instring" name="group"/>
						</td>
					</tr>
				</table>
				<input type="submit" class="button" value="Знайти.." name="fin" />
			</form>
			        <?php  searchtest(); ?>
        </div>
		<div id="pleft">
			<p class="myh">Створити тест</p>
			<form action="../newtest/newtest.php" method="POST">
				<table style="margin-bottom: 20px;">
						<tr><td>Оберіть предмет: <a href="../reg/subject/reg.php" style="font-size: 0.6em;">(створ.)</a></td></tr>
						<tr><td>
							<select  id = "sub" name="subjectfortest" class="selectof" onChange="getid('sub');" style="margin-top: 20px; margin-bottom: 10px;">
								<option value=0 selected="selected">...</option>
								<?php
									show_sub_list();
								?>
							</select>
							<a onclick="return confirm('Ви впевнені?')" style="font-size: 0.6em;" id="delsub" href="" >Видал.</a>
						</td></tr>
						<tr><td>Введіть тему:</td></tr>
						<tr><td><input type="text" class="instring" style="margin-top: 10px;" name="theme"/></td></tr>
				</table>
				<input type="submit" class="button" style="margin-left: 0px; margin-top: 5px;" name="create" value="Створити.."/>
			</form>
		</div>
		<div id="pright">
			<p class="myh">Остання активність</p>
			<div id="lresults">
                <table style = "font-size: 14px; text-align: center; left: -10px;">
                    <col width="100">
                    <col width="150">
                    <col width="50">
                    <col width="150">
                    <col width="60">
			        <?php
                        show_l_results();
			        ?>
                </table>
			</div>
		</div>
	</div>
	<?php
        showerrors();
	?>
	<div id="exit">
		<a href="../logout.php"><img src="../../styles/share/exit.gif" style="width: 50px;" /></a>
	</div>
	<p id="bottom"></p>
</div>
</body>