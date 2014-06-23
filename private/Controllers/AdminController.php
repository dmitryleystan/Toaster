<?php
session_start();

$ds = DIRECTORY_SEPARATOR;
$base_dir = realpath(dirname(__FILE__)  . $ds . '..') . $ds;
require_once("{$base_dir}/Modules/HostName.php");
require_once("{$base_dir}/Models/Admin.php");
require_once("{$base_dir}/Modules/RightsValidation.php");
userrights('admin');

$model = new CAdmin();

function searchtest()   // show search test window
{
    global $model;

    $sub = $_POST['subject'];
    $ftheme = $_POST['ftheme'];

    if (isset($_POST['fin']))
    {
        $tests = $model->findtests($sub, $ftheme);

        foreach($tests as $test)
        {
            echo "<tr><td>$test[2]</td>";
            $subject_name = $model->getTestSubject($test[1]);
            echo "<td>$subject_name</td>";
            echo '<td><a href=' . "./journal.php?vg=" . $test[0] .'>групи</a></td>';
            echo '<td style = "width: 40px;"><a href="./reg/rates.php?tid='. $test[0] .'">тар.</a>&nbsp;
						<a href="' . $_SERVER['PHP_SELF'] . '?dt='. $test[0] .'">вид.</a></td></tr>';
        }

    }

}

function show_l_results()  // show last results
{
    global $model;
    $l_results = $model->getLastResults();

    echo "<tr><th>Предмет</th> <th>Назва тесту</th> <th>Балл</th> <th>Дата</th> <th>Нік</th></tr>";

	foreach($l_results as $res)
	echo "<tr><td>$res[0]</td> <td>$res[1]</td> <td>$res[2]</td> <td>$res[3]</td> <td>$res[4]</td></tr>";
}

if (!empty($_GET['dt']))    // if we want delete test
{
    require_once("{$base_dir}/Classes/TestClass.php");
    $mytest = new CTest();
    $mytest -> tid = $_GET['dt'];
    $mytest -> deltest();
}

if (!empty($_GET['delsub']))    // if we want delete subject..
{                               //also all tests of it's will be deleted to
    global $host;
    $sid = $_GET['delsub'];
    $model->delSubject($sid);
    header("Location: http://$host/views/admin/index.php?ok=1");
}

function show_sub_list()        // subject combobox
{
    global $model;
    $id_and_name = $model->getSubjects();
    $ids = $id_and_name[0];
    $names = $id_and_name[1];

    for($i = 0; $i < count($names); $i++)
    echo '<option value="'. $ids[$i] .'">'. $names[$i] .'</option>';
}

function showerrors()           // messages...
{
    if ($_GET['er'] == 1)
        myerror('Ви не ввели найменування тесту або не вказали предмет..');
    if ($_GET['ok'] == 1)
        myerror('Виконано..');
}

function visibility()           // visibility of test search field
{
    global $search_field_visisible;
    if (!$search_field_visisible)
        echo 'style="visibility: hidden"';
}

if (isset($_POST['fin']))       // set attributes of visibility if we search test
    $search_field_visisible = true;
else
    $search_field_visisible = false;

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