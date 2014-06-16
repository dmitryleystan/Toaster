<?php
require_once("{$base_dir}Classes{$ds}DataBaseClass.php"); // include DataBase Class

class CLogin
{
    private
        $mydb;

    public

        function __construct(){
        $this->mydb = new CDataBase('ross','sunshine');
        }

        function login($user, $password){
            $query = "SELECT * FROM users WHERE name = '$user'";
            $result = $this->mydb->selectdata($query);
            while ($str = mysql_fetch_array($result, MYSQLI_NUM))
            {
                if (($str[1]==$user) && ($str[2]==$password))   // bingo?
                {
                    mysql_free_result($result);
                    mysql_close($this->mydb);
                    $_SESSION['uid'] = $str[0];
                    $_SESSION['nick'] = $str[1];
                    $_SESSION['rights'] = $str[3];
                    mysql_free_result($result);
                    $this->mydb->close();
                    if ($str[3] == "admins")
                        return 2;   // admin
                    else
                        return 1;   // student
                }
            }
            return 0;

        }
}
