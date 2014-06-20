<?php
require_once ('../share/header.php');

require_once ('../share/RightsValidation.php');
userrights('admin');
$host = $_SERVER['HTTP_HOST'];

$number = $_GET['number'];
if (empty($number))
	{
		if ( ($_POST['subjectfortest']==0) || (empty($_POST['theme'])) )
			{
				mysql_close($db);
				header("Location: ../admin/index.php?er=1");
			}
		$number = 1;
	}

require_once('../share/DataBaseClass.php');
$mydb = new database('ross','sunshine');
if (isset($_POST['create'])) 
	{
		if ($_POST['subjectfortest']!=0)
			{
				$idsub = $_POST['subjectfortest'];
				$query = "SELECT * FROM subjects WHERE id LIKE '$idsub'";
				$result = $mydb -> selectdata($query);
				$str = mysql_fetch_array($result, MYSQLI_NUM);
				$namesub = $str[1]; // знайшов предмет по айдішку
			}

		if (!empty($_POST['theme']))
			{
				$tname = $_POST['theme'];
				$query = "INSERT INTO tests (idsub, name) VALUES($idsub, '$tname')";
				$mydb -> insertdata($query);
				$query = "SELECT * FROM tests WHERE name LIKE '$tname'";
				$result = $mydb -> selectdata($query);
				$str = mysql_fetch_array($result, MYSQLI_NUM);
				$id = $str[0]; // знайшов присвоєну тесту айдішку			
			}
	}
else
	if ($number>1) 
		{
			$id = $_GET['id'];
			$ques = mysql_escape_string( trim($_POST['question']) );
			$type = $_POST['type'];
			switch ($type) {
				case 'logical':			/// логічне запитання: так або ні
					$answer = $_POST['logical'];
					$query = "INSERT INTO questions (idtest, cond, qtype) VALUES ($id, '$ques', 2)";
					$mydb -> insertdata($query);

					$query = "SELECT id FROM questions WHERE cond LIKE '$ques'";
					$result = $mydb -> selectdata($query);
					$str = mysql_fetch_array($result, MYSQLI_NUM);
					$idq = $str[0]; // знайшов присвоєну питанню айдішку
					$query = "INSERT INTO answers2 (qid,answer) VALUES($idq,'$answer')";	
					$mydb -> insertdata($query);
				break;

				case 'typical':			/// звичайне тестове запитання
					$query = "INSERT INTO questions (idtest, cond, qtype) VALUES ($id, '$ques', 1)";
					$mydb -> insertdata($query);
					$query = "SELECT id FROM questions WHERE cond LIKE '$ques'";
					$result = $mydb -> selectdata($query);
					$str = mysql_fetch_array($result, MYSQLI_NUM);
					$idq = $str[0]; // знайшов присвоєну питанню айдішку

					$answers = array();

					while ($curField = each($_POST))
						{
    						if (strpos($curField['key'], 'std') !== FALSE)
        						$answers[] = $curField['value'];
						}

					$n = count($answers);
					$cor = $_POST['stch'];
					for ($i = 0; $i < $n; $i++)
						if (!empty($answers[$i]))
							{
								if (in_array($i, $cor)) $c = 1; else $c = 0;
								$answ = $answers[$i];
								$query = "INSERT INTO answers1 (qid, answer, mright) VALUES ($idq, '$answ', $c)";
								$mydb -> insertdata($query);
							}
					break;

				case 'comlicated':			/// відповідність
					$query = "INSERT INTO questions (idtest, cond, qtype) VALUES ($id, '$ques', 3)";
					$mydb -> insertdata($query);
					$query = "SELECT * FROM questions WHERE id = (SELECT max(id) FROM questions)";
					$result = $mydb -> selectdata($query);
					$str = mysql_fetch_array($result, MYSQLI_NUM);
					$idq = $str[0];			// знайшов присвоєну питанню айдішку

					$answl = array();
					$answr = array();

					while ($curField = each($_POST))
					 	{
        					if (strpos($curField['key'], 'vidl') !== FALSE)
        						$answl[] = $curField['value'];	// виділяю елементи, що стоять зліва
        					if (strpos($curField['key'], 'vidr') !== FALSE)
        						$answr[] = $curField['value'];	// виділяю елементи, що стоять справа
						}

					$n = count($answl);
					for ($i = 0; $i < $n; $i++)
						if (!empty($answl[$i]))
							{
								$answ = $answl[$i];
								$query = "INSERT INTO answers3 (qid, answer, side) VALUES ($idq, '$answ', true)";
								$mydb -> insertdata($query);
							}

					$n = count($answr);
					for ($i = 0; $i < $n; $i++)
						if (!empty($answr[$i]))
							{
								$answ = $answr[$i];
								$query = "INSERT INTO answers3 (qid, answer, side) VALUES ($idq, '$answ', false)";
								$mydb -> insertdata($query);
							}	
					break;
			}

		}

?>

<script type="text/javascript">
	var ks = 0;
	var kl = 0;
	var kr = 0;
	function addNext(mydiv, shbl)
		{ 
				mdiv = document.getElementById(mydiv);
				ediv = document.createElement("div");
				inp = document.createElement("input");
				inp.setAttribute('type', 'text');
				switch (mydiv)
					{
   						case 'pright':
   							ks++;
							inp.setAttribute('name', shbl + ks);
							inp.setAttribute('id', shbl + ks);
							inp.setAttribute('style', 'width: 160px; margin: 5px;');

							inpch = document.createElement("input");
							inpch.setAttribute('type', 'checkbox');
							inpch.setAttribute('name', 'stch[]');
							inpch.setAttribute('value', ks);
							inpch.setAttribute('id', 'stch' + ks);
							ediv.appendChild(inpch);
      					break
   						case 'compr':
   							kr++;
							inp.setAttribute('name', shbl + kr);
							inp.setAttribute('id', shbl + kr);
							inp.setAttribute('style', 'width: 170px;');
      					break
   						case 'compl':
   							kl++;
							inp.setAttribute('name', shbl + kl);
							inp.setAttribute('id', shbl + kl);
							inp.setAttribute('style', 'width: 170px;');    				
      					break
      				}
				inp.setAttribute('size', '25');
				ediv.appendChild(inp);
				mdiv.appendChild(ediv);
				

		}

	function delPrev(shbl)
		{
			switch (shbl)
				{
					case 'std':
						if (ks>0)
						{
							var el = document.getElementById(shbl + ks);
							el.parentNode.removeChild(el);
							var el = document.getElementById('stch' + ks);
							el.parentNode.removeChild(el);
							ks--;
						}
					break
					case 'vidl':
						if (kl>0)
						{
							var el = document.getElementById(shbl + kl);
							el.parentNode.removeChild(el);
							kl--;
						}
					break
					case 'vidr':
						if (kr>0)
						{
							var el = document.getElementById(shbl + kr);
							el.parentNode.removeChild(el);
							kr--;
						}
					break
				}
		}


	</script> 