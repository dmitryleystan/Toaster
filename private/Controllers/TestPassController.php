<?php
session_start();
$condition = null;
$ds = DIRECTORY_SEPARATOR;
$base_dir = realpath(dirname(__FILE__)  . $ds . '..') . $ds;
require_once("{$base_dir}Modules/HostName.php");
require_once("{$base_dir}Classes/UserClass.php");
require_once("{$base_dir}Classes/TestClass.php");
require_once("{$base_dir}Modules/RightsValidation.php");
userrights('user');

$myuser = new CUser();                  // Who I am?
$myuser->uname = $_SESSION['nick'];
$myuser->uid = $_SESSION['uid'];

$mytest = new CTest();                  // Which of tests I want to pass
$mytest->tid = $_GET['tid'];  // tid => test id
$tid = $mytest->tid;

//$qid = $_GET['qid'];
$number = $_GET['n'];
if (empty($number))
{
	$number = 0;
    $questionsId = $mytest -> getQuestionsId();  // reading all questions id's
    shuffle($questionsId);
    $_SESSION['qids'] = $questionsId;
}
else
    $questionsId = $_SESSION['qids'];


$qid = $questionsId[$number];
$condition = $mytest -> getquestion($qid);


$lqid = $qid; /// The question which we have already passed
$qid = $condition[0]; /// Next question which we should pass
$last = $qid;

function showquestion()
	{
		global $condition;
		switch ($condition[2]) 
			{
				case '1':
					$vs = $condition[3];    // various of answers
					$n = count($vs);
					shuffle($vs);
					for ($i = 0; $i < $n; $i++)
						echo '<p><input type="checkbox" name="stand[]" value = "sta' . $vs[$i][0] . '" /> ' . $vs[$i][1] . '</p>';
					echo '<input type="hidden" name ="sttt" value = "1" />';
				break;
			
				case '2':
					echo '<p><input type="radio" name="log" value="2" /> Так</p>';
					echo '<p><input type="radio" name="log" value="1" checked = "true"/> Ні</p>';
				break;

				case '3':
					echo '<input type="hidden" name = "com" id = "com" value="1" />';
					$an = $condition[3];
					$vsl = $an[0];
					$vsr = $an[1];
					echo '<div id="answleft"> ';
						$n = count($vsl);
						shuffle($vsl);
						for ($i = 0; $i < $n; $i++)
							echo '<p  class = "noselect"><span id = "cl' . $vsl[$i][0] . '" 
						onClick="Chcolor(' . "'" . 'cl' . $vsl[$i][0] . "'" . ');">' . $vsl[$i][1] . '</span>
						<input type="hidden" name = "ucl' . $vsl[$i][0] . '" id = "ucl' . $vsl[$i][0] . '" value="8" /></p>';

					echo '</div>';

					echo '<div id="answright"> ';
						$n = count($vsr);
						shuffle($vsr);
						for ($i = 0; $i < $n; $i++)
							echo '<p  class = "noselect"><span id = "cr' . $vsr[$i][0] . '" 
						onClick="Chcolor(' . "'" . 'cr' . $vsr[$i][0] . "'" . ');">' . $vsr[$i][1] . '</span></p>
						<input type="hidden" name = "ucr' . $vsr[$i][0] . '" id = "ucr' . $vsr[$i][0] . '" value="8" /></p>';

					echo '</div>';
				break;
			}
	}


if ($number == 0)   // if it's new test
 	{
 		unset($_SESSION['anws']);
 		$_SESSION['anws'] = array();
 	}

if (!empty($_POST['log']))
	{
		$answ = $_POST['log'];
		$answar = $_SESSION['anws'];
		$el = array('log', $lqid, $answ - 1);
		unset($_SESSION['anws']);
		$answar[] = $el;
		$_SESSION['anws'] = $answar;
	}

if (!empty($_POST['sttt']))
	{
		$answs = $_POST['stand'];
		$answar = $_SESSION['anws'];
		$el = array('stand', $lqid, $answs);
		unset($_SESSION['anws']);
		$answar[] = $el;
		$_SESSION['anws'] = $answar;
	}

if (!empty($_POST['com']))
	{
		$ucl = array();
		$ucr = array();
		while ($curField = each($_POST))
			{
    			if (strpos($curField['key'], 'ucl') !== FALSE)
       				{
       					$vs[0] = substr($curField['key'],3);
       					$vs[1] = $curField['value'];
       					$ucl[] = $vs;
       				}

    			if (strpos($curField['key'], 'ucr') !== FALSE)
       				{
       					$vs[0] = substr($curField['key'],3);
       					$vs[1] = $curField['value'];
       					$ucr[] = $vs;
       				}
			}

		$answar = $_SESSION['anws'];
		$answ[0] = $ucl;
		$answ[1] = $ucr;
		$el = array('comp', $lqid, $answ);
		unset($_SESSION['anws']);
		$answar[] = $el;
		$_SESSION['anws'] = $answar;
	}

if (empty($condition[1]))
	{
		$mark = $mytest -> checkup();
		$_SESSION['showmark'] = 1;
		$_SESSION['mark'] = $mark;
		$_SESSION['tid'] = $mytest->tid;
		header("Location: http://$host/views/user/index.php");
	}
?>

<script type="text/javascript">
	var a = ["red", "green", "yellow", "white", "grey", "rosybrown", "chocolate"];
	var lcolor = "none";
	function Chcolor(idspan)
		{
			i = 0;
			myspan = document.getElementById(idspan);
			if (lcolor != "none")
				i = a.indexOf(lcolor);
			i++;
			if (i > 7) i = 0;
			lcolor = a[i];
			myspan.setAttribute('style', 'padding: 4px; border-radius: 15px; margin-bottom: 15px; background-color: '+ a[i] +';');
			myhidden = document.getElementById('u'+idspan);
			myhidden.setAttribute('value', i);
		}
</script>