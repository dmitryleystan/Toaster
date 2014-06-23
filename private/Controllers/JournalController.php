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
	if (!empty($mygroups))
		{
			$aboutl = 'showgroupstatist';
			$aboutr = 'showusersbygroup';
			$r = $mygroups;
			$l = $mygroups;
		}
	else
		$error_string = 'Ви не обрали групу..';

if (!empty($inf))									            // we want see inf about user?
	{
		$aboutl = 'showuserinf';
		$aboutr = 'showuserres';
		$r = $inf;
		$l = $inf;
		$myuser->uid = $inf;
		$lid = "?inf=" . $inf . "&ok=1";
	}

if (isset($_POST['saveusinf']))						            // we want update user inf?
	{
		$myuser -> uid = $_GET['inf'];
		$fn = $_POST['userfname'];
		$ln = $_POST['userlname'];
		$fa = $_POST['userfathname'];
		$myuser -> saveinf($fn,$ln,$fa);
	}

if (!empty($_GET['vg']))							            // we want see inf about test?
	{
		$aboutl = 'showtestinf';
		$aboutr = 'showgroupsshare';
		$l = $_GET['vg'];
		$lid = "?vg=" . $l;
	}

if (isset($_POST['sharetest']))						            // we want share test?
    $mytest->reggroups($mygroups, $_GET['vg']);

if (isset($_POST['savetsinf']))						            // want del some group from test?
		{
			$mgroup = $_POST['grtodel'];
			$mytest->delgroups($mgroup, $_GET['vg']);
		}

if ($_GET['ok'] == 1)									        // something go right :)
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

function g_users_list($gid)
{
    global $model;
    $users = $model->getUsersByGroup($gid);
    foreach($users as $user)
        echo '<tr><td><a href="' . $_SERVER['PHP_SELF'] .'?inf='. $user[0]. '">'
            . $user[1] . '</a></td><td>' . $user[2] . '</td>' .
            '<td><input type="checkbox" name="users[]"' . "value=$user[0] /></td></tr>";
}

function userinf($uid)
{
    $uinf = array();
    $user = new CUser();
    $user->uid = $uid;
    $user->getname();
    $usergroups = "";
    $groups = $user->getUserGroups();
    foreach($groups as $group)
        $usergroups += (" " + $group);
    $uinf[] = $uid; $uinf[] = $user->uname;
    $uinf[] = $groups;
    $uinf[] = array($user->getinf('lname'), $user->getinf('fname'), $user->getinf('fathname'));
    return $uinf;
}

function groupinf($gid)
{
    $ginf = array();
    $gr = new CGroup();
    $gr->gid = $gid;
    $gr->getname();
    $ginf[] = $gid; $ginf[] = $gr->gname;
    $ginf[] = $gr->users_count();
    return $ginf;
}

function testinf($tid)
{
    $tinf = array();
    $mt = new CTest();
    $mt->tid = $tid;
    $tinf[] = $tid;
    $tinf[] = $mt->getname();
    $tinf[] = $mt->getTestGroups();
    $tinf[] = $mt->getsub();
    return $tinf;
}

function group_test_list($tid, $group_list)
{
    foreach($group_list as $group)
    echo '<tr><td><input type="checkbox" name="grtodel[]"' . "value=$group[1] /></td>"
        . '<td><a href="../statistic/results.php?shg=' . $group[1] . '&sht=' . $tid .' ">'
        . $group[0] . "</a></td></tr>";
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
            $gid = $varibl;
            require_once("{$base_dir}/shablons/journal/group_users.php");
            break;

        case 'showuserres':
            require_once("{$base_dir}/shablons/journal/user_results.php");
            break;

        case 'showgroupsshare':
            require_once("{$base_dir}/shablons/journal/share_test.php");
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
            $group = groupinf($varibl);
            require_once("{$base_dir}/shablons/journal/group_statist.php");
            break;

        case 'showuserinf':
            $user = userinf($varibl);
            require_once("{$base_dir}/shablons/journal/user_info.php");
            break;

        case 'showtestinf':
            $test = testinf($varibl);
            require_once("{$base_dir}/shablons/journal/test_info.php");
            break;
    }
    return 0;
}