<?php
include_once("{$base_dir}Classes/DataBaseClass.php");

	class CJournal
		{
			private $mydb;

			public function __construct()
				{
					$this -> mydb = new CDataBase('ross','sunshine');
				}

			public function kilusers($gid)
				{
					$kil = 0;
					$query = "SELECT * FROM usandgr WHERE idgroup = $gid";
					$result = $this -> mydb -> selectdata($query);
					while($str = mysql_fetch_array($result, MYSQLI_NUM))
						$kil++;
					return $kil;
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
                    $groups = array();
					$query = "SELECT * FROM groups WHERE name LIKE '$gname%'";
					$result = $this -> mydb -> selectdata($query);
					while($str = mysql_fetch_array($result, MYSQLI_NUM))
						{
							$kil = $this -> kilusers($str[0]);
                            $groups[] = array($str[0], $str[1], $kil); // id, name, count of users
						}

					return $groups;
				}


			public function showgroupst($id)
				{
					$gr = new group();
					$gr -> gid = $id;
					$nm = $gr -> getname();
					echo '
					<p class="head">Статистика "' . $nm . '"</p>
					<p>Кільскість користувачів групи: '
					. $this -> kilusers($id) . ' </p>
					';
					unset($gr);
					return 0;
				}

			public function showusersbygroup($id)
				{

					//////////////////////////////////////////////////////////
					$query = "SELECT users.id, users.name, users.ugroup FROM users INNER JOIN usandgr 
					ON usandgr.iduser = users.id WHERE usandgr.idgroup = '$id'";
					$result = $this -> mydb -> selectdata($query);
					while($str = mysql_fetch_array($result, MYSQLI_NUM))
						{
							$h = "?inf=" . $str[0];
							echo '<tr>
							<td><a href="' . $_SERVER['PHP_SELF'] . $h .'">' . $str[1] . '</a></td>
							<td>' . $str[3] . '</td>' .
							'<td><input type="checkbox" name="users[]"' . "value=$str[0] /></td>
							</tr>";
						}
					//////////////////////////////////////////////////////////

					return 0;

				}

			public function showtestinf($i)
				{
					$mt = new test();
					$mt -> tid = $i;
					echo '<p class="head">"' . $mt -> getname() . '"</p>';
					echo '
						<div style = "height: 195px;">
							<p>Назва тесту:</p>
							<p><input type="text" name="testname" value="' . $mt -> tname . '" /></p>
							<p>Предмет: ' . $mt -> getsub() . '</p>
							<p>Групи для яких тест доступний(відмітьте які бажаєте видалити зі списку):</p>';
						echo '<table> <col width="30"> <col width="100">';
						$mt -> showgroups();
						echo '
						</table>	
						</div>
						<p style="margin-top: 200px">														<!-- кнопочки -->
							<input type="submit" class="button" value="Зберегти" name="savetsinf" />
						</p>
					';					
					return 0;
				}
 
			public function showgroupsshare($gname)
				{

					///////////////////////////////////////////////////////////
					$kil = 0;
					$query = "SELECT * FROM groups WHERE name LIKE '$gname%'";
					$result = $this -> mydb -> selectdata($query);
					while($str = mysql_fetch_array($result, MYSQLI_NUM))
						{
							$kil = $this -> kilusers($str[0]);
							echo "<tr>
							<td>$str[1]</td>
							<td>$kil</td>" .
							'<td><input type="checkbox" name="groups[]"' . "value=$str[0] /></td>
							</tr>";
						}
					///////////////////////////////////////////////////////////
					echo '

					';					
				}

			public function showuserres($varibl)
				{
					echo '
					';
					return 0;
				}





			public function close()
				{
					$this -> mydb -> close();
					return 0;
				}
		}