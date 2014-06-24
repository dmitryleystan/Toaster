<?php
include_once("{$base_dir}Classes/DataBaseClass.php");

class Registration {
    private
        $mydb;

    public

    function __construct()
    {
        $this->mydb = new CDataBase();
    }

    function create_user($uname, $passwd, $right)
    {
        $error = 0;
        $query = "SELECT * FROM users WHERE name LIKE '$uname'";
        $result = $this->mydb->selectdata($query);
        while ($str = mysql_fetch_array($result, MYSQLI_NUM))
        {
            if ($uname == $str[1])
                $error = 1;
        }

        if ($error == 1)
            return 1;
        else
        {
            $query = "INSERT INTO users (name, password, ugroup) VALUES('$uname', '$passwd', '$right')";
            $this->mydb->insertdata($query);
            return 0;
        }
    }

    function create_group($groupname)
    {
        $query = "SELECT name FROM groups WHERE name LIKE '$groupname'";
        $result = $this->mydb->selectdata($query);
        $str = mysql_fetch_array($result, MYSQLI_NUM);
        if ($groupname == $str[0])
            return 1;
        else
        {
            $query = "INSERT INTO groups (name) VALUES ('$groupname')";
            $this->mydb->insertdata($query);
            return 0;
        }

    }


    function create_subject($subname)
    {
        $query = "SELECT sname FROM subjects WHERE sname LIKE '$subname'";
        $result = $this->mydb->selectdata($query);
        $str = mysql_fetch_array($result, MYSQLI_NUM);
        if ($subname == $str[0])
            return 1;
        else
        {
            $query = "INSERT INTO subjects (sname) VALUES ('$subname')";
            $this->mydb->insertdata($query);
            return 0;
        }
    }
} 