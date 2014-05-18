<?php
	require_once ('../../share/instruments.php');
	require_once ('../../share/myheader.php');
	require_once('../../share/classdb.php');
	require_once('../../share/classtest.php');
	require_once('../../share/classgroup.php');
	require_once('../../share/classuser.php');
	$mygroup = new group();
	$mytest = new test();
	$myuser = new user();

		if (!empty($_GET['clg']))
			{
				$mytest -> tid = $_GET['clt'];
				$mytest -> delresult($_GET['clg']);
				header("Location: http://$host/admin/admin.php?ok=1");
			}

	$mygroup -> gid = $_GET['shg'];
	$mytest -> tid = $_GET['sht'];
	$gname = $mygroup -> getname();
	$tname = $mytest -> getname();
	$gid = $mygroup -> gid; $tid = $mytest -> tid;
	function showmarks()
		{
			global $mygroup, $myuser, $mytest, $tid;
			$arofus = $mygroup -> getusers();
			$n = count($arofus);
			echo '
				<col width="150px">
				<col width="160px">
				<col width="100px">
				<col width="150px">
			';
			echo "<tr><th>Логін</th><th>ПІБ</th><th>Оцінка</th><th>Дата та час</th></tr>";
			for ($i=0; $i < $n; $i++) 
				{ 
					$mark = 0;
					$date = 0;
					$ulog = $arofus[$i][1];
					$myuser -> uid = $arofus[$i][0];

					$lname = $myuser -> getinf('lname');
					$fname = $myuser -> getinf('fname');
					$uname = $lname . ' ' . $fname;

					$res = $mytest -> getresult($myuser -> uid);
					$marks = $res[0];
					$date = $res[1];
					$k = count($marks);

					echo "<tr><td>$ulog</td><td>$uname</td><td style = " . '"text-align: center;"' . ">";
					for ($j=0; $j < ($k-1); $j++)
						echo $marks[$j] . ", ";
					echo $marks[$j];
					echo "</td><td>$date</td></tr>";

				}
		}
?>