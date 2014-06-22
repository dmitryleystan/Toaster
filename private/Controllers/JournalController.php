<?php
session_start();

$ds = DIRECTORY_SEPARATOR;
$base_dir = realpath(dirname(__FILE__)  . $ds . '..') . $ds;
require_once("{$base_dir}/Modules/HostName.php");
require_once("{$base_dir}/Modules/ErrorMessage.php");
require_once("{$base_dir}/Models/Admin.php");
require_once("{$base_dir}/Modules/RightsValidation.php");
userrights('admin');
require_once("{$base_dir}Models/Journal.php");
require_once("{$base_dir}Classes/UserClass.php");
require_once("{$base_dir}Classes/GroupClass.php");
require_once("{$base_dir}Classes/TestClass.php");


$model = new CJournal();
$mygroup = new CGroup();
$myuser = new CUser();
$mytest = new CTest();

$users = $_POST['users'];
$mygroups = $_POST['groups'];
$do = $_GET['do'];
$aboutl = 'showusers';
$aboutr = 'showgroups';
$inf = $_GET['inf'];

$groupname = $_POST['groupname'];                               // we want find some group?
$username = $_POST['username'];

if (isset($_POST['mreg']))	                                    // we want reg users in group?
	if (!empty($mygroups))
		$myuser->regusers($users, $mygroups);
	else
        $error_string = 'Ви не обрали групу..';

if (isset($_POST['delus']))                                     // we want delete users?
	$myuser -> delusers($users);

if (isset($_POST['delgroup']))	                                // we want delete group?
	{
		$gid = $mygroups;                                       // gid - group id
		$mygroup -> delgroup($gid);
	}

if (isset($_POST['viewgroup']))                                 // we want view group information?
	if (!empty($mgroup))
		{
			$aboutl = 'showgroupstatist';
			$aboutr = 'showusersbygroup';
			$r = $mygroups;
			$l = $mygroups;
		}
	else
		$error_string = 'Ви не обрали групу..';

if (!empty($inf))									            // якщо хочем переглянути інформацію
	{												            // що стосується юзера
		$aboutl = 'showuserinf';
		$aboutr = 'showuserres';
		$r = $inf;
		$l = $inf;
		$myuser->uid = $inf;
		$lid = "?inf=" . $inf . "&ok=1";
	}

if (isset($_POST['saveusinf']))						            // якщо хочем зберегти інформацію
	{												            // юзера
		$myuser -> uid = $_GET['inf'];
		$fn = $_POST['userfname'];
		$ln = $_POST['userlname'];
		$fa = $_POST['userfathname'];
		$myuser -> saveinf($fn,$ln,$fa);
	}

if (!empty($_GET['vg']))							            // перегляд інформації стосовно тесту
	{
		$aboutl = 'showtestinf';
		$aboutr = 'showgroupsshare';
		$l = $_GET['vg'];
		$lid = "?vg=" . $l;
	}

if (isset($_POST['sharetest']))						            // розшарити тест?
			$mytest->reggroups($mygroups, $_GET['vg']);

if (isset($_POST['savetsinf']))						            // зберегти інфу по тесту = видалити з нього деякі групи
		{
			$mgroup = $_POST['grtodel'];
			$mytest->delgroups($mygroups , $_GET['vg']);
		}

if ($_GET['ok'] == 1)									        // для того аби вивести повідомлення успішності операції
	$error_string = "Виконано";

function groups_list($gname)
{
    global $model;
    $groups = $model->getGroups($gname);
    foreach ($groups as $group)
    echo "<tr><td>$group[1]</td><td>$group[2]</td>" .
         '<td><input type="radio" name="groups"' .
         "value=$group[0] /></td></tr>";
}

function users_list($uname)
{
    global $model;
    $users = $model->getUsers($uname);
    foreach($users as $user)
        echo '<tr><td><a href="' . $_SERVER['PHP_SELF'] .'?inf='. $user[0]. '">'
        . $user[1] . '</a></td><td>' . $user[2] . '</td>' .
        '<td><input type="checkbox" name="users[]"' . "value=$user[0] /></td></tr>";
}



function showrightpage($about, $varibl)
{
    global $base_dir, $groupname;
    switch ($about)
    {
        case 'showgroups':
            require_once("{$base_dir}/shablons/journal/group_list.php");
            break;
        case 'showusersbygroup':
            $this -> showusersbygroup($varibl);
            break;
        case 'showuserres':
            require_once("{$base_dir}/shablons/journal/user_results.php");
            break;
        case 'showgroupsshare':
            $this -> showgroupsshare($varibl);
            break;
    }

    return 0;
}

function showleftpage($about, $varibl)
{
    global $base_dir, $username;
    switch ($about)
    {
        case 'showusers':
            require_once("{$base_dir}/shablons/journal/users_list.php");
            break;
        case 'showgroupstatist':
            $this -> showgroupst($varibl);
            break;
        case 'showuserinf':
            $user = new CUser();
            $user->uid = $varibl;
            $user->getname();
            $usergroups = "";
            $groups = $user->getUserGroups();
            foreach($groups as $group)
                $usergroups += (" " + $group);
            require_once("{$base_dir}/shablons/journal/user_info.php");
            break;
        case 'showtestinf':
            $this -> showtestinf($varibl);
            break;
    }
    return 0;
}