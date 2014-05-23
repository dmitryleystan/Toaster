<?php
require_once ('../share/instruments.php');
userrights('admin');

require_once ('../share/classdb.php');
$mydb = new database('ross','sunshine');

$query = "SELECT * FROM subjects";
$result = $mydb -> selectdata($query);

$id = array();
$name = array();
while($str = mysql_fetch_array($result, MYSQLI_NUM))
	{
		array_push($id, $str[0]);
		array_push($name, $str[1]);
	}

function searchtest()
	{
				global $mydb;
				$sub = $_POST['subject'];
				$ftheme = $_POST['ftheme'];
				$groupl = $_POST['group'];
				if (isset($_POST['fin']))
					{
						echo '
									<div id= "find" >
										<table>
											<col width="150">
											<col width="70">
											<col width="80">
											<col width="70">
							';

						if ($sub != 0)
								$query = "SELECT * FROM tests WHERE name LIKE '$ftheme%' AND idsub LIKE '$sub'";
						else
								$query = "SELECT * FROM tests WHERE name LIKE '$ftheme%'";
						$result = $mydb -> selectdata($query);
				
						while($str = mysql_fetch_array($result, MYSQLI_NUM))
							{ 
								echo "<tr><td>$str[2]</td>";
								$query = "SELECT * FROM subjects WHERE id LIKE '$str[1]'";
								$res = $mydb -> selectdata($query);
									$subj = mysql_fetch_array($res, MYSQLI_NUM);
									echo "<td>$subj[1]</td>";
								echo '<td><a href=' . "./groups/groups.php?vg=" . $str[0] .'>групи</a></td>';
								echo '<td style = "width: 40px;"><a href="./settar/settar.php?tid='. $str[0] .'">тар.</a>&nbsp;
								<a href="' . $_SERVER['PHP_SELF'] . '?dt='. $str[0] .'">вид.</a></td></tr>';
								
							}

						echo '
										</table>
									</div>
							';
					}
					if (!empty($_GET['dt']))
						{
							require_once('../share/classtest.php');
							$mytest = new test();
							$mytest -> tid = $_GET['dt'];
							$mytest -> deltest();
						}
	}

function showlastresults()
{
	global $mydb;
	$query = "SELECT subjects.sname, tests.name, tsession.mark, tsession.sdata, users.name FROM tsession 
	INNER JOIN tests INNER JOIN subjects INNER JOIN users ON tsession.idtest = tests.id WHERE
	subjects.id = tests.idsub AND tsession.iduser = users.id GROUP BY tsession.sdata DESC LIMIT 5";
	$result = $mydb -> selectdata($query);
	echo '<table style = "font-size: 14px; text-align: center; left: -10px;">';
	echo '
	<col width="100">
	<col width="150">
	<col width="50">
	<col width="150">
	<col width="60">
	';
	echo "<tr><th>Предмет</th> <th>Назва тесту</th> <th>Балл</th> <th>Дата</th> <th>Нік</th></tr>";
	while($str = mysql_fetch_array($result, MYSQLI_NUM))
	echo "<tr><td>$str[0]</td> <td>$str[1]</td> <td>$str[2]</td> <td>$str[3]</td> <td>$str[4]</td></tr>";
	echo "</table>";
}

if (!empty($_GET['delsub']))
	{
		require_once('../share/classtest.php');
		$mytest = new test();
		$sid = $_GET['delsub'];
		$query = "DELETE FROM subjects WHERE id = $sid";
		$mydb -> deldata($query);
		$query = "SELECT id FROM tests WHERE idsub = $sid";
		$result = $mydb -> selectdata($query);
		while ($str = mysqli_fetch_array($result, MYSQLI_NUM))
			{
				echo "string!!!!!!!!!!!";
				$mytest -> tid = $str[0];
				$mytest -> deltest();
			}
		header("Location: http://$host/admin/admin.php?ok=1");
	}
?>

<script type="text/javascript">
	var subid = -1;
	function getid(idsel)
		{
			mysel = document.getElementById(idsel);
			subid = mysel.value;
			mya = document.getElementById('delsub');
			mya.setAttribute('href', "<?php echo $_SERVER['PHP_SELF']; ?>?delsub=" + subid);
		}
</script>