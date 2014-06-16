<?php
require_once('../../../private/Controllers/UserController.php');
require_once('../header.php');
?>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Кабінет користувача</title>
	<link rel="stylesheet" type="text/css" href="../../styles/share.css" />
	<link rel="stylesheet" type="text/css" href="../../styles/user.css" />
	<link rel="shortcut icon" href="../../styles/share/logo.png" type="image/x-icon">
    <?php js_sh_rcount($rcount, $show_rcount) ?>
    </head>

<body>

<p id="user"><?php echo $uname; ?></p>

<div id="content">
	<p id="first">Ласкаво просимо</p>
	<div id="center">
		<div id="left">
			<p class="second">Особисті дані</p>
            <p>Прізвище:</p>
            <p><?php echo $lastname;  ?></p>
            <p>Ім'я:</p>
            <p><?php echo $firstname; ?></p>
            <p>По-батькові:</p>
            <p><?php echo $fathername;?></p>
            <p>Групи до яких належить користувач:</p>
            <p>
            <?php echo $group_list; ?>
            </p>
            <p>Наявні для проходження тести</p>
            <?php showtests(); ?>

		</div>
		<div id="right">
			<p class="second">Останні результати</p>
			<div id="results">
            <table style = "font-size: 14px; text-align: center; left: -10px;">
				<col width="100">
				<col width="150">
				<col width="50">
				<col width="100">
                <tr><td>Предмет</td> <td>Назва тесту</td> <td>Бал</td> <td>Дата</td></tr>
                <?php showmarks(); ?>
            </table>
			</div>
		</div>
	</div>
</div>


<div id="exit">
	<a href="../logout.php">
        <img src="../../styles/share/exit.gif" style="width: 50px;" />
    </a>
</div>
<p id="bottom"></p>
</body>
</html>