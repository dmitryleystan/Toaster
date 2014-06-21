<?php
session_start();

$ds = DIRECTORY_SEPARATOR;
$base_dir = realpath(dirname(__FILE__)  . $ds . '..') . $ds;
require_once("{$base_dir}/Modules/HostName.php");
require_once("{$base_dir}/Models/Admin.php");
require_once("{$base_dir}/Modules/RightsValidation.php");
userrights('admin');
require_once("{$base_dir}Classes/JournalClass.php");
require_once("{$base_dir}Classes/UserClass.php");
require_once("{$base_dir}Classes/GroupClass.php");
require_once("{$base_dir}Classes/TestClass.php");

$mybook = new CJournal();
$mygroup = new CGroup();
$myuser = new CUser();
$mytest = new CTest();

//$l = $_POST['username'];
//$r = $_POST['groupname'];
$users = $_POST['users'];
$mgroup = $_POST['groups'];
$do = $_GET['do'];
$aboutl = 'showusers';
$aboutr = 'showgroups';
$inf = $_GET['inf'];

if (isset($_POST['mreg']))	// якщо ми хочемо зареєструвати юзерів у групи
	if (!empty($mgroup))
		$myuser -> regusers($users, $mgroup);
	else
		myerror('Ви не обрали групу..');

if (isset($_POST['delus']))	// якщо ми хочемо видалити юзерів
	$myuser -> delusers($users);

if (isset($_POST['delg']))	// якщо ми хочемо видалити групи
	{
		$gid = $_GET['lid'];
		$mygroup -> delgroup($gid);
	}

if (isset($_POST['viewgroup']))	// якщо ми хочемо переглянути інформацію по групі
	if (!empty($mgroup))
		{
			$aboutl = 'showgroupstatist';
			$aboutr = 'showusersbygroup';
			$r = $mgroup;
			$l = $mgroup;
		}
	else
		myerror('Ви не обрали групу..');

if (isset($_POST['delgroup']) && (!empty($mgroup))) // якщо ми хочемо видалити групу
	$lid = "?lid=" . $mgroup;						// треба про це перепитати

if (!empty($inf))									// якщо хочем переглянути інформацію
	{												// що стосується юзера
		$aboutl = 'showuserinf';
		$aboutr = 'showuserres';
		$r = $inf;
		$l = $inf;
		$myuser -> uid = $inf;
		$lid = "?inf=" . $inf . "&ok=1";
	}

if (isset($_POST['saveusinf']))						// якщо хочем зберегти інформацію
	{												// юзера
		$myuser -> uid = $_GET['inf'];
		$fn = $_POST['userfname'];
		$ln = $_POST['userlname'];
		$fa = $_POST['userfathname'];
		$myuser -> saveinf($fn,$ln,$fa);
	}

if (!empty($_GET['vg']))							// перегляд інформації стосовно тесту
	{
		$aboutl = 'showtestinf';
		$aboutr = 'showgroupsshare';
		$l = $_GET['vg'];
		$lid = "?vg=" . $l;
	}

if (isset($_POST['sharetest']))						// розшарити тест?
			$mytest -> reggroups($mgroup, $_GET['vg']);

if (isset($_POST['savetsinf']))						// зберегти інфу по тесту = видалити з нього деякі групи
		{
			$mgroup = $_POST['grtodel'];
			$mytest -> delgroups($mgroup , $_GET['vg']);
		}

if ($_GET['ok']==1)									// для того аби вивести повідомлення успішності операції
	myerror('Виконано..');
?>