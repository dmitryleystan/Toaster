<?php
require_once ("{$base_dir}/Classes/DataBaseClass.php");

class CAdmin {

private

    $mydb;

public

function __construct()
{
    $this->mydb = new CDataBase();
}

function getSubjects()
{
    $id = array();
    $name = array();
    $query = "SELECT * FROM subjects";
    $result = $this->mydb->selectdata($query);
    while($str = mysql_fetch_array($result, MYSQLI_NUM))
    {
        $id[]    = $str[0];
        $name[]  = $str[1];
    }
    $subjects[0] = $id;
    $subjects[1] = $name;
    return $subjects;
}

function findtests($sub, $ftheme)
{
    if ($sub != 0)
        $query = "SELECT * FROM tests WHERE name LIKE '$ftheme%' AND idsub LIKE '$sub'";
    else
        $query = "SELECT * FROM tests WHERE name LIKE '$ftheme%'";

    $tests = array();
    $result = $this->mydb->selectdata($query);
    while($str = mysql_fetch_array($result, MYSQLI_NUM))
        $tests[] = $str;

    return $tests;
}

function getTestSubject($tid)
{
    $query = "SELECT * FROM subjects WHERE id LIKE '$tid'";
    $res = $this->mydb->selectdata($query);
    $subject_name = mysql_fetch_array($res, MYSQLI_NUM);
    return $subject_name[1];
}

function getLastResults()
{
    global $mydb;
    $query = "SELECT subjects.sname, tests.name, tsession.mark, tsession.sdata, users.name FROM tsession
	INNER JOIN tests INNER JOIN subjects INNER JOIN users ON tsession.idtest = tests.id WHERE
	subjects.id = tests.idsub AND tsession.iduser = users.id GROUP BY tsession.sdata DESC LIMIT 5";

    $l_results = array();
    $result = $this->mydb->selectdata($query);
    while($str = mysql_fetch_array($result, MYSQLI_NUM))
        $l_results[] = $str;

    return $l_results;
}

function delSubject($sid)
{
    require_once("../Classes/TestClass.php");
    $mytest = new CTest();
    $query = "DELETE FROM subjects WHERE id = $sid";
    $this->mydb->deldata($query);
    $query = "SELECT id FROM tests WHERE idsub = $sid";
    $result = $this->mydb -> selectdata($query);
    while ($str = mysqli_fetch_array($result, MYSQLI_NUM))
    {
        $mytest->tid = $str[0];
        $mytest->deltest();
    }
}

} 