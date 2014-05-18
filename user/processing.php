<?php
require_once ('../share/myheader.php');
	require_once('../share/classdb.php');
	require_once('../share/classuser.php');
session_start();
$q = $_SESSION['nick'];
$myuser = new user();
$myuser -> uname = $q;

if ($_SESSION['showmark'] == 1)
{
	$frfr = $_SESSION['mark'];
	$m = 2;
	if ($frfr >= 0.525) $m = 3;
	if ($frfr >= 0.675) $m = 4;
	if ($frfr >= 0.86) $m = 5;
	
	$tid = $_SESSION['tid'];
	$myuser -> setmark($m, $tid);
	echo '
		<script type="text/javascript">
		alert(' . "'" . " Правельних відповідей: " . $_SESSION['shmark'] . "');
		</script>
	";

	unset($_SESSION['showmark']);
	unset($_SESSION['mark']);
	unset($_SESSION['shmark']);
}
function showinfo()
	{
		global $myuser, $q;
		$myuser -> uname = $q;
		$uid = $myuser -> getuid();
		echo "<p>Прізвище:</p>";
		echo "<p>" . $myuser -> getinf('lname') . "</p>";
		echo "<p>Ім'я: </p>";
		echo "<p>" . $myuser -> getinf('fname') . "</p>";
		echo "<p>По-батькові:</p>";
		echo "<p>" . $myuser -> getinf('fathname') . "</p>";
		echo "<p>Групи до яких належить користувач:</p>";
		echo "<p>";
		$myuser -> usergroups();
		echo "</p>";
		echo "<p>Наявні для проходження тести</p>";
		$myuser -> showtests();
			
	}

?>