<?php
include_once("{$base_dir}Classes/DataBaseClass.php");

class CBuildTest
{
private

    $mydb;

    function __construct()
    {
        $this->mydb = new CDataBase();
    }

public

    function getSubName($sid)                                 // Get subject name
    {
        $query = "SELECT * FROM subjects WHERE id LIKE '$sid'";
        $result = $this->mydb->selectdata($query);
        $str = mysql_fetch_array($result, MYSQLI_NUM);
        return $str[1];
    }

    function regNewTest($tname, $sid)                         // Registrate new test and return this id
    {
        $query = "INSERT INTO tests (idsub, name) VALUES($sid, '$tname')";
        $this->mydb->insertdata($query);
//        $query = "SELECT * FROM tests WHERE name LIKE '$tname'";
//        $result = $this->mydb->selectdata($query);
//        $str = mysql_fetch_array($result, MYSQLI_NUM);
        return mysql_insert_id();                                       // return test id
    }

    function newLogicalQ($tid, $question, $answer)
    {
        $query = "INSERT INTO questions (idtest, cond, qtype) VALUES ($tid, '$question', 2)";
        $this->mydb->insertdata($query);

//        $query = "SELECT id FROM questions WHERE cond LIKE '$question'";
//        $result = $this->mydb->selectdata($query);
//        $str = mysql_fetch_array($result, MYSQLI_NUM);
        $idq = mysql_insert_id();

        $query = "INSERT INTO answers2 (qid,answer) VALUES($idq,'$answer')";
        $this->mydb->insertdata($query);
    }

    function newStandartQ($tid, $question, $answers, $correct)
    {
        $query = "INSERT INTO questions (idtest, cond, qtype) VALUES ($tid, '$question', 1)";
        $this->mydb->insertdata($query);
//        $query = "SELECT id FROM questions WHERE cond LIKE '$question'";
//        $result = $this->mydb->selectdata($query);
//        $str = mysql_fetch_array($result, MYSQLI_NUM);
        $idq = mysql_insert_id();                                   // last id -> id of question

        for ($i = 0; $i < count($answers); $i++)
            if (!empty($answers[$i]))
            {
                if (in_array($i, $correct)) $c = 1; else $c = 0;
                $answer = $answers[$i];
                $query = "INSERT INTO answers1 (qid, answer, mright) VALUES ($idq, '$answer', $c)";
                $this->mydb->insertdata($query);
            }
    }

    function newComplicatedQ($tid, $question, $answl, $answr)
    {
        $query = "INSERT INTO questions (idtest, cond, qtype) VALUES ($tid, '$question', 3)";
        $this->mydb->insertdata($query);
//        $query = "SELECT * FROM questions WHERE id = (SELECT max(id) FROM questions)";
//        $result = $this->mydb->selectdata($query);
//        $str = mysql_fetch_array($result, MYSQLI_NUM);
//        $idq = $str[0];
        $idq = mysql_insert_id();                                   // last id -> id of question

        foreach($answl as $answ)
            if (!empty($answ))
            {
                $query = "INSERT INTO answers3 (qid, answer, side) VALUES ($idq, '$answ', true)";
                $this->mydb->insertdata($query);
            }

        foreach($answr as $answ)
            if (!empty($answ))
            {
                $query = "INSERT INTO answers3 (qid, answer, side) VALUES ($idq, '$answ', false)";
                $this->mydb->insertdata($query);
            }
    }
}