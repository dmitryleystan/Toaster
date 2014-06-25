<?php
session_start();

$ds = DIRECTORY_SEPARATOR;
$base_dir = realpath(dirname(__FILE__)  . $ds . '..') . $ds;
require_once("{$base_dir}/Modules/HostName.php");
include_once("{$base_dir}Models/Registration.php");
require_once("{$base_dir}/Modules/ErrorMessage.php");
require_once("{$base_dir}/Modules/RightsValidation.php");
userrights('admin');

$model = new Registration();
$error_string = "";

if (isset($_POST['newuser']))                                   // we want create new user?
{
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $rights = $_POST['rights'];

    if (!(empty($user) || empty($pass)))
    {
        if ($rights == 'Yes')
            $right = "admins";
        else
            $right = "users";

        $error = $model->create_user($user, $pass, $right);
        if ($error == 0)
            header("Location: http://$host/views/admin/journal.php?ok=1");   // So, alright
        else
            $error_string = ' такий користувач вже існує!';
    }
    else
        $error_string = ' забули ввести логін/пароль!';
}


if (isset($_POST['newgroup']))                                  // we want create new group?
{

    $groupname = $_POST['groupname'];
    $host = $_SERVER['HTTP_HOST'];
    $find = 1;

    if (!empty($groupname))
    {
        $error = $model->create_group($groupname);
        if ($error == 0)
            header("Location: http://$host/views/admin/journal.php?ok=1");
        else
            $error_string = ' така група вже існує!';
    }
    else
        $error_string = ' Введіть назву нової групи!';
}


if (!empty($_GET['uid']))                                       // we want change user password?
{
    require_once("{$base_dir}/Classes/UserClass.php");
    $myuser = new CUser();
    $myuser -> uid = $_GET['uid'];
    $lid = '?uid=' . $_GET['uid'];

    if (isset($_POST['chpasswd']))
        if ((!empty($_POST['passw'])) && (!empty($_POST['passwconf'])))
        {
            if ($_POST['passw'] == $_POST['passwconf'])
            {
                $myuser -> changepassw($_POST['passw']);
                $host = $_SERVER['HTTP_HOST'];
                header("Location: http://$host/views/admin/journal?inf=" . $_GET['uid']); 
            }
            else
                $error_string = ' Поля не збігаються!';
        }
        else
            $error_string = ' Ви не заповнили всі поля!';
}

if (isset($_POST['newsub']))                                    // we want create new subject?
{
    $subname = $_POST['subname'];
    $host = $_SERVER['HTTP_HOST'];

    if (!empty($subname))
    {
        $error = $model->create_subject($subname);
        if ($error == 0)
            header("Location: http://$host/views/admin/journal.php?ok=1");
        else
            $error_string = ' такий предмет вже існує!';
    }
    else
        $error_string = ' Введіть назву нового предмету!';
}


if (!empty($_GET['tid']))                                       // we want change rates in test?
{
    require_once("{$base_dir}Classes/TestClass.php");
    $mytest = new CTest();
    $tid = $_GET['tid'];
    $mytest -> tid = $_GET['tid'];
    if (isset($_POST['ch_tar']))
    {
        $tar = array($_POST['cost1'], $_POST['cost2'], $_POST['cost3']);
        $mytest -> settar($tar);
        header("Location: http://$host/views/admin/index.php?ok=1");
    }
    $tar = $mytest -> gettar();
}