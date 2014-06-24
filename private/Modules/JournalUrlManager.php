<?php
/////       This is the module which IS USED ONLY IN JournalController
/////       that reconstruct the user request

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
{
    $error = $mytest->reggroups($mygroups, $_GET['vg']);
    switch($error){
        case 0:
            $error_string = "Виконано";
            break;
        case 1:
            $error_string = "Деякі групи вже були підписані на тест";
            break;
        case 2:
            $error_string = "Ви не обрали групу";
            break;
    }
}
if (isset($_POST['savetsinf']))						            // want del some group from test?
{
    $mgroups = $_POST['grtodel'];
    if (!empty($mgroups))
        $mytest->delgroups($mgroups, $_GET['vg']);
}

if ($_GET['ok'] == 1)									        // something go right :)
    $error_string = "Виконано";