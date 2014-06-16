<?php
session_start();
$ds = DIRECTORY_SEPARATOR;
$base_dir = realpath(dirname(__FILE__)  . $ds . '..') . $ds;
require_once("{$base_dir}Modules{$ds}HostName.php");
include_once("{$base_dir}Models{$ds}Login.php");    // model
include_once("{$base_dir}Modules{$ds}RightsValidation.php");
include_once("{$base_dir}Modules{$ds}ErrorMessage.php");

$error_code = 0;
if (!empty($_SESSION['rights']))    // if I already entered in system
    if ($_SESSION['rights'] == 'admins')
        header("Location: http://$host/views/admin/admin.php");
    else
        header("Location: http://$host/views/user/index.php");

if (isset($_POST['enter'])) // if I already want to enter in system
{
    $user = $_POST['user'];
    $pass = $_POST['pass'];

    if ((empty($user)) || (empty($pass)))
        $error_code = 1;    // validation
    else
    {

        $model = new CLogin;
        $login_code = $model->login($user, $pass);
        switch ($login_code){
            case 2:
                header("Location: http://$host/views/admin/admin.php?un=$user");
                break;
            case 1:
                header("Location: http://$host/views/user/index.php?un=$user");
                break;
            case 0:
                $error_code = 2;
        }
    }
}

function errors(){
    global $error_code;
    switch ($error_code)
    {
        case 1:
            myerror('забули ввести логін/пароль!');
            break;
        case 2:
            myerror(' невірний логін/пароль!');
            break;
    }
}