<?php
include_once("{$base_dir}Classes/DataBaseClass.php");

	class CJournal
		{
			private $mydb;
			private $errorst;

			public function __construct()
				{
					$this -> mydb = new CDataBase('ross','sunshine');
				}

			public function myerror()
				{
					echo '<p id = "error">' . $this -> errorst . '</p>';
					return 0;
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

			public function showusers($uname)
				{
					echo '			
					<p class="head">Користувачі</p>
						<!-- наповнення -->
					<div class="page">
						<table>
							<col width="100">
							<col width="100">
							<col width="50">
							<tr><td>Ім' . "'" . 'я корист.</td><td>Права</td><td>Відміт.</td></tr>';

					//////////////////////////////////////////////////////////
					$query = "SELECT * FROM users WHERE name LIKE '$uname%'";
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
					echo '
							</table>
						</div>
							<!-- кінець наповнення -->
						<div class="downtitle">
							<p class="instring"><input type="text" class="findfild" name="username" 
							value="' . $_POST['username'] . '"/></p>  <!-- поле пошуку -->
							<p style="margin-top: 5px">														<!-- кнопочки -->
								<input type="submit" class="button" value="Знайти" name="finduser" />
								<input type="submit" class="button" value="Реєструвати" name="mreg" />
								<input type="submit" class="button" value="Видалити" name="delus" />
							</p>
						</div>';
					return 0;
				}

			public function showgroups($gname)
				{
					echo '
					<p class="head">Групи</p>
					<!-- наповнення -->
					<div class="page">
					<table>
						<col width="100">
						<col width="100">
						<col width="50">
						<tr><td>Ім'. "'" .'я групи.</td><td>К-сть учасн.</td><td>Відміт.</td></tr>
					';
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
							'<td><input type="radio" name="groups"' . "value=$str[0] /></td>
							</tr>";
						}
					///////////////////////////////////////////////////////////
					echo '
						</table>
					</div>
					<!-- кінець наповнення -->
					<div class="downtitle">
						<p class="instring"><input type="text" class="findfild" name="groupname"
						value="' . $_POST['groupname'] . '" /></p>  <!-- поле пошуку -->
						<p style="margin-top: 5px"> 													<!-- кнопочки -->
							<input type="submit" class="button" value="Знайти" name="findgroup" />
							<input type="submit" class="button" value="Перегляд" name="viewgroup" />
							<input type="submit" class="button" value="Видалити" name="delgroup" />
						</p>
					</div>
					';
					return 0;					
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
					echo '			
					<p class="head">Користувачі групи</p>
						<!-- наповнення -->
					<div class="page">
						<table>
							<col width="100">
							<col width="100">
							<col width="50">
							<tr><td>Ім' . "'" . 'я корист.</td><td>Права</td><td>Відміт.</td></tr>';

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
					echo '
							</table>
						</div>
							<!-- кінець наповнення -->
						<div class="downtitle">
							<p class="instring"><input type="text" class="findfild" name="username" 
							value="' . $_POST['username'] . '"/></p>  <!-- поле пошуку -->
							<p style="margin-top: 5px">														<!-- кнопочки -->
								<input type="submit" class="button" value="Знайти" name="finduser" />
								<input type="submit" class="button" value="Видалити" name="delus" />
							</p>
						</div>';
					return 0;

				}

			public function showuserinf($i)
				{
					$us = new user();
					$us -> uid = $i;
					$us -> getname();
					echo '			
					<p class="head">' . $us -> uname . '</p>';
					echo '
						<div id="info">
							<p>Прізвище:</p>
							<p><input type="text" name="userfname" value="' . $us -> getinf('lname') . '" /></p>
							<p>Імя:</p>
							<p><input type="text" name="userlname" value="' . $us -> getinf('fname') . '" /></p>
							<p>По-батькові:</p>
							<p><input type="text" name="userfathname" value="' . $us -> getinf('fathname') . '" /></p>
							<p><a href="../../reg/chuserpsw/chpassw.php?uid=' . $us -> uid . '">Змінити пароль</a></p>
							<p>Групи до яких належить користувач:</p>
							<p>';
							$us -> usergroups();
							echo '</p>
						</div>

						<p style="margin-top: 125px">														<!-- кнопочки -->
							<input type="submit" class="button" value="Зберегти" name="saveusinf" />
						</p>
					';
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
					echo '
					<p class="head">Групи</p>
					<!-- наповнення -->
					<div class="page">
					<table>
						<col width="100">
						<col width="100">
						<col width="50">
						<tr><td>Ім'. "'" .'я групи.</td><td>К-сть учасн.</td><td>Відміт.</td></tr>
					';
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
						</table>
					</div>
					<!-- кінець наповнення -->
					<div class="downtitle">
						<p class="instring"><input type="text" class="findfild" name="groupname"
						value="' . $_POST['groupname'] . '" /></p>  <!-- поле пошуку -->
						<p style="margin-top: 5px"> 													<!-- кнопочки -->
							<input type="submit" class="button" value="Знайти" name="findgroup" />
							<input type="submit" class="button" value="Розшарити" name="sharetest" />
						</p>
					</div>
					';					
				}

			public function showuserres($varibl)
				{
					echo '
					<div>
						<p style="margin-top: 50px;">Середній балл користувача:</p>
						<p>Ще не пройдені але наявні для користувача тести:</p>
						<p>Пройдені тести та їх результати:</p>
					</div>';
					return 0;
				}

			public function showleftpage($about, $varibl)
				{
					switch ($about) 
					{
						case 'showusers':
							$this -> showusers($varibl);
							break;
						case 'showgroupstatist':
							$this -> showgroupst($varibl);
							break;
						case 'showuserinf':
							$this -> showuserinf($varibl);
							break;
						case 'showtestinf':
							$this -> showtestinf($varibl);
							break;
					}
					return 0;
				}

			public function showrightpage($about, $varibl)
				{
					switch ($about) 
					{
						case 'showgroups':
							$this -> showgroups($varibl);
							break;
						case 'showusersbygroup':
							$this -> showusersbygroup($varibl);
							break;
						case 'showuserres':
							$this -> showuserres($varibl);
							break;
						case 'showgroupsshare':
							$this -> showgroupsshare($varibl);
							break;
					}

					return 0;
				}

			public function deletention()
				{
					echo '
					<div id="really">
						<p style="font-size: 18px; margin-left: 50px;">Ви впевнені?</p>
						<p>
							<input type="submit" value="Так" name="delg" style="width: 65px; margin-left: 50px" />
							<input type="submit" value="Ні" name="no"  style="width: 65px; margin-left: 10px"/>
						</p>
					</div>';
				}

			public function close()
				{
					$this -> mydb -> close();
					return 0;
				}
		}
?>