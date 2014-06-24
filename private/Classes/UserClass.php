<?php
include_once("DataBaseClass.php");

class CUser
{
	private $mydb;
	public $uid;
	public $uname;
	public $ugroup;

	public function __construct()
	{
		$this -> mydb = new CDataBase();
	}

	public function regusers($array, $gr)
	{
		$n = count($array);		// кількість студентів для реєстрації
		if (empty($gr))			// якщо група не була обрана
			myerror('Ви не обрали жодної групи..');
		else					
			if ($n != 0)	// якщо був обраний хоч один студент для реєстрації
				for ($i = 0; $i < $n; $i++)
				{
					$query = "SELECT * FROM usandgr WHERE iduser = '$array[$i]' AND idgroup = '$gr'";
					$result = $this -> mydb -> selectdata($query);
					$str = mysql_fetch_array($result);

					if ($str[0] == '') // якщо користувач вже не був зареєстрований у даній групі...
					{
						$query = "INSERT INTO usandgr (iduser, idgroup) VALUES('$array[$i]','$gr')";
						$this -> mydb -> insertdata($query);
						myerror('Виконано..');
					}
					else
							myerror('Деякі користувачі вже належали даній групі..');
				}
			else
				myerror('Ви не обрали жодного користувача..');			
		return 0;
	}

	public function delusers($array)
	{
		$n = count($array);
		if ($n != 0)	// якщо був обраний хоч один студент для реєстрації
		{
			for ($i = 0; $i < $n; $i++)
			{
						$query = "DELETE FROM users WHERE id = '$array[$i]'";
						$this -> mydb -> deldata($query);
						$query = "DELETE FROM usandgr WHERE iduser = '$array[$i]'";
						$this -> mydb -> deldata($query);
						myerror('Виконано..');
			}
		}
		else
			myerror('Ви не обрали жодного користувача..');					
		return 0;
	}

	public function getUserGroups()
	{
		if (!empty($this -> uname))
		{
			$nm = $this -> uname;
			$query = "SELECT groups.name FROM groups INNER JOIN usandgr INNER JOIN users ON 
			usandgr.idgroup = groups.id WHERE users.name = '$nm' AND usandgr.iduser = users.id";
		}
		else
		{
			$nm = $this -> uid;
			$query = "SELECT groups.name FROM groups INNER JOIN usandgr INNER JOIN users ON 
			usandgr.idgroup = groups.id WHERE users.id = '$nm' AND usandgr.iduser = users.id";
		}
		$result = $this -> mydb -> selectdata($query);
        $glist = "";
		while($str = mysql_fetch_array($result, MYSQLI_NUM))
			$glist .= "$str[0] ";
		unset($nm);
		return $glist;
	}

	public function getname()
	{
		$i = $this -> uid;
		$query = "SELECT name FROM users WHERE id = '$i'";
		$result = $this -> mydb -> selectdata($query);
		$str = mysql_fetch_array($result);
		$this -> uname = $str[0];
		return $str[0];
	}

	public function getuid()
	{
		$n = $this -> uname;
		$query = "SELECT id FROM users WHERE name = '$n'";
		$result = $this -> mydb -> selectdata($query);
		$str = mysql_fetch_array($result);
		$this -> uid = $str[0];
		return $str[0];
	}

	public function getugroup()
	{
		$i = $this -> uid;
		$query = "SELECT ugroup FROM users WHERE id = '$i'";
		$result = $this -> mydb -> selectdata($query);
		$str = mysql_fetch_array($result);
		$this -> ugroup = $str[0];
		return $str[0];
	}			

	public function getinf($what)
	{
		if (empty($this -> uid))
			$this -> getuid();
		$i = $this -> uid;
		switch ($what) 
		{
			case 'fname':
				$query = "SELECT fname FROM usinfo INNER JOIN users USING(id) WHERE id = '$i'";
				$result = $this -> mydb -> selectdata($query);
				$str = mysql_fetch_array($result);
				break;
			case 'lname':
				$query = "SELECT lastname FROM usinfo INNER JOIN users USING(id) WHERE id = '$i'";
				$result = $this -> mydb -> selectdata($query);
				$str = mysql_fetch_array($result);
				break;
			case 'fathname':
				$query = "SELECT fathname FROM usinfo INNER JOIN users USING(id) WHERE id = '$i'";
				$result = $this -> mydb -> selectdata($query);
				$str = mysql_fetch_array($result);
				break;
		}
		return $str[0];
	}			

	public function setmark($m, $t)
	{
		$this -> getuid();
		$u = $this -> uid;
		$query = "INSERT INTO tsession(iduser, idtest, mark, sdata) VALUES ($u, $t, $m, NOW())";
		$this -> mydb -> insertdata($query);
	}

	public function saveinf($f, $l, $fa)
	{
		$i = $this -> uid;
		$query = "SELECT id FROM usinfo INNER JOIN users USING(id) WHERE id = '$i'";
		$result = $this -> mydb -> selectdata($query);
		$str = mysql_fetch_array($result);
		if (!empty($str[0]))
		{
			$query = "DELETE FROM usinfo WHERE id = '$i'";
			$this -> mydb -> deldata($query);
		}
		$query = "INSERT INTO usinfo VALUES('$i','$l','$f','$fa')";
		$this -> mydb -> insertdata($query);
		return 0;
	}

	public function gettests()
	{
		$uid = $this -> getuid();
		$query = "SELECT tests.id, tests.name FROM tests 
		INNER JOIN testandgr INNER JOIN groups INNER JOIN usandgr INNER JOIN users 
		ON tests.id = testandgr.idtest WHERE testandgr.idgroup = groups.id 
		AND groups.id = usandgr.idgroup AND usandgr.iduser = '$uid' GROUP BY tests.id";

		$result = $this -> mydb -> selectdata($query);
        $res = array();
		While ($str = mysql_fetch_array($result, MYSQLI_NUM))
			$res[] = $str;
		return $res;
	}

	public function getmarks()
	{
		$u = $this -> uid;
		$query = "SELECT subjects.sname, tests.name, tsession.mark, tsession.sdata FROM tsession 
		INNER JOIN tests INNER JOIN subjects ON tsession.iduser = $u WHERE
		tsession.idtest = tests.id AND subjects.id = tests.idsub GROUP BY tsession.sdata DESC";
		$result = $this -> mydb -> selectdata($query);
        $res = array();
        for($i=0; $str = mysql_fetch_array($result, MYSQLI_NUM); $i++)
            $res[$i] = $str;
        return $res;
	}

	public function changepassw($newpassw)
	{
		$i = $this -> uid;
		$name = $this -> getname();
		$ugroup = $this -> getugroup();
		$query = "DELETE FROM users WHERE id = '$i'";
		$this -> mydb -> deldata($query);
		$query = "INSERT INTO users (id, name, password, ugroup) 
		VALUES ('$i', '$name', '$newpassw', '$ugroup')";
		$this -> mydb -> insertdata($query);
		return 0;
	}

	public function close()
	{
		$this -> mydb -> close();
		return 0;
	}
}
