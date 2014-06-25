<?php
$ds = DIRECTORY_SEPARATOR;
$base_dir = realpath(dirname(__FILE__)  . $ds . '..') . $ds;

require_once("{$base_dir}/Modules/HostName.php");
require_once("{$base_dir}/Models/BuildTest.php");
require_once("{$base_dir}/Modules/RightsValidation.php");
userrights('admin');


$number = $_GET['number'];

if (empty($number))
{
	if ( ($_POST['subjectfortest'] == 0) || (empty($_POST['theme'])) )
		header("Location: ./index.php?er=1");
	$number = 1;
}

$model = new CBuildTest();

if (isset($_POST['create']))
{
    $sid = $_POST['subjectfortest'];    // sid => subject id
    $subname = $model->getSubName($sid);
	$tname = $_POST['theme'];
    $tid = $model->regNewTest($tname, $sid);
}
else
	if ($number>1) 
	{
		$tid = $_GET['tid'];
		$ques = mysql_escape_string( trim($_POST['question']) );
		$type = $_POST['type'];
		switch ($type) {
            case 'logical':			/// logical question: yes or no
				$answer = $_POST['logical'];
                $model->newLogicalQ($tid, $ques, $answer);
			break;

			case 'typical':			/// typical question with various of answers
                $answers = array();

                while ($curField = each($_POST))
                    if (strpos($curField['key'], 'std') !== FALSE)
                        $answers[] = $curField['value'];
                $correct = $_POST['stch'];
                $model->newStandartQ($tid, $ques, $answers, $correct);
				break;

            case 'comlicated':			/// conformity question: many to many
                $answl = array();
                $answr = array();

                while ($curField = each($_POST))
                {
                    if (strpos($curField['key'], 'vidl') !== FALSE)
                        $answl[] = $curField['value'];	// виділяю елементи, що стоять зліва
                    if (strpos($curField['key'], 'vidr') !== FALSE)
                        $answr[] = $curField['value'];	// виділяю елементи, що стоять справа
                }

                $model->newComplicatedQ($tid, $ques, $answl, $answr);
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