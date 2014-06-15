<?php
$ds = DIRECTORY_SEPARATOR;
$base_dir = realpath(dirname(__FILE__)  . $ds . '..') . $ds;
require_once("{$base_dir}Classes{$ds}DataBaseClass.php");
require_once("{$base_dir}Classes{$ds}UserClass.php");
require_once("{$base_dir}Modules{$ds}ShowRCount.php");
require_once ("{$base_dir}Modules{$ds}RightsValidation.php");
userrights('user'); // validate user
                                                ///         USER IDENTIFICATION
$uname = $_SESSION['nick'];                     /// uname => username
$myuser = new user();                           ///
$myuser -> uname = $uname;                      ///
$uid = $myuser -> getuid();                     /// get user id
$lastname =   $myuser -> getinf('lname');       ///
$firstname =  $myuser -> getinf('fname');       ///
$fathername = $myuser -> getinf('fathname');    ///

$show_rcount = false;
if ($_SESSION['showmark'] == true) //   if some test is done
{
	$coefficient = $_SESSION['mark'];
	$m = 2;
	if ($coefficient >= 0.525) $m = 3;
	if ($coefficient >= 0.675) $m = 4;
	if ($coefficient >= 0.86) $m = 5;
	
	$tid = $_SESSION['tid'];    // "tid" => "test id"
	$myuser -> setmark($m, $tid);

    $rcount = $_SESSION['shmark']; // count of right answers

	unset($_SESSION['showmark']);
	unset($_SESSION['mark']);
	unset($_SESSION['shmark']);
}

$results = $myuser->getmarks();
$tests = $myuser->gettests();
$group_list = $myuser -> usergroups();
$myuser -> close();

function showmarks()
{
    global $results;
    foreach($results as $str)
        echo "<tr><td>$str[0]</td> <td>$str[1]</td> <td>$str[2]</td> <td>$str[3]</td></tr>";
}

function showtests()
{
    global $tests;
    foreach($tests as $str)
        echo '<a href="./starttest.php?id=' . $str[0] . '">' . $str[1] . '</a><br />'; /// +  '&u=' . $uid .
}
