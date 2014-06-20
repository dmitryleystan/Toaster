<?php
require_once('../../../private/Controllers/ResultsController.php');
require_once('../header.php');
?>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?php echo "$gname - $tname"; ?></title>
	<link rel="stylesheet" type="text/css" href="../../share/share.css" />
	<link rel="stylesheet" type="text/css" href="./statist.css" />
	<link rel="shortcut icon" href="../../share/images/logo.png" type="image/x-icon">
</head>

<body>
	<p> Результати групи <?php echo $gname; ?> з тесту "<?php echo $tname; ?>" 
	<a onclick="return confirm('Ви впевнені?')" 
	href="results.php?clg=<?php echo $gid; ?>&clt=<?php echo $tid; ?>">(Очистити)</a></p>
	<table border = "2" rules="all" cellpadding="2">
        <col width="150px">
        <col width="160px">
        <col width="100px">
        <col width="150px">
        <tr><th>Логін</th><th>ПІБ</th><th>Оцінка</th><th>Дата та час</th></tr>
		<?php showmarks(); ?>
	</table>

	<div id="mend"><a href="../admin.php">На головну</a></div>
	<div id="exit">
		<a href="../../share/logout.php"><img src="../../share/images/exit.gif" style="width: 50px;" /></a>
	</div>
	<div id="bottom"></div>
</body>

</html>