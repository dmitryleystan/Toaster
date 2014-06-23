<?php
include_once("{$base_dir}Classes/DataBaseClass.php");

	class CJournal
		{
			private $mydb;

			public function __construct()
				{
					$this -> mydb = new CDataBase('ross','sunshine');
				}

			public function getUsers($uname)
				{
					$query = "SELECT * FROM users WHERE name LIKE '$uname%'";
					$result = $this -> mydb -> selectdata($query);
                    $users = array();
					while($str = mysql_fetch_array($result, MYSQLI_NUM))
                        $users[] = array($str[0], $str[1], $str[3]);

					return $users;
				}

			public function getGroups($gname)
				{
                    $group = new CGroup();
                    $groups = array();
					$query = "SELECT * FROM groups WHERE name LIKE '$gname%'";
					$result = $this -> mydb -> selectdata($query);
					while($str = mysql_fetch_array($result, MYSQLI_NUM))
						{
                            $group->gid = $str[0];
							$kil = $group->users_count($str[0]);
                            $groups[] = array($str[0], $str[1], $kil); // id, name, count of users
						}

					return $groups;
				}

			public function getUsersByGroup($gid)
				{
                    $query = "SELECT users.id, users.name, users.ugroup FROM users INNER JOIN usandgr
					ON usandgr.iduser = users.id WHERE usandgr.idgroup = '$gid'";
                    $result = $this -> mydb -> selectdata($query);
                    $users = array();
                    while($str = mysql_fetch_array($result, MYSQLI_NUM))
                        $users[] = $str;

					return $users;
				}

			public function close()
				{
					$this -> mydb -> close();
					return 0;
				}
		}