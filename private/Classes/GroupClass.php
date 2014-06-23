<?php
include_once("{$base_dir}Classes/DataBaseClass.php");

	class CGroup
	{
		private $mydb;
		public $gid;
		public $gname;

		public function __construct()
			{
				$this -> mydb = new CDataBase('ross','sunshine');
			}

		public function getusers()
			{
				$g = $this -> gid;
				$query = "SELECT users.id, users.name FROM users INNER JOIN usandgr 
				ON usandgr.iduser = users.id WHERE usandgr.idgroup = $g";
				$result = $this -> mydb -> selectdata($query);
				$a = array();
				while ($str = mysql_fetch_array($result))
					$a[] = $str;
				return $a;
			}

		public function delgroup($gid)
			{
				$query = "DELETE FROM groups WHERE id = '$gid'";
				$this -> mydb -> deldata($query);
				$query = "DELETE FROM usandgr WHERE idgroup = '$gid'";
				$this -> mydb -> deldata($query);
				myerror('Виконано..');

				return 0;
			}

		public function getname()
			{
				$i = $this->gid;
				$query = "SELECT name FROM groups WHERE id = '$i'";
				$result = $this -> mydb -> selectdata($query);
				$str = mysql_fetch_array($result);
				$this->gname = $str[0];
				return $str[0];
			}

		public function getgid()
			{
				$n = $this -> gname;
				$query = "SELECT id FROM groups WHERE id = '$n'";
				$result = $this -> mydb -> selectdata($query);
				$str = mysql_fetch_array($result);
				$this -> gid = $str[0];
				return $str[0];
			}

        public function users_count()
        {
            $kil = 0;
            $gid = $this->gid;
            $query = "SELECT * FROM usandgr WHERE idgroup = $gid";
            $result = $this -> mydb -> selectdata($query);
            while($str = mysql_fetch_array($result, MYSQLI_NUM))
                $kil++;
            return $kil;
        }

		public function close()
			{
				$this -> mydb -> close();
				return 0;
			}
	}
