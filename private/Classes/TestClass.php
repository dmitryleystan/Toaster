<?php
require_once("{$base_dir}Classes/DataBaseClass.php");

class CTest
{
	private $mydb;
	public $tid;
	public $tname;

	public function __construct()
	{
		$this -> mydb = new CDataBase('ross','sunshine');
	}

	public function showgroups()
	{
		$i = $this -> tid;
		$query = "SELECT name, id FROM groups INNER JOIN testandgr 
		ON testandgr.idgroup = groups.id WHERE testandgr.idtest = '$i'";
		$result = $this -> mydb -> selectdata($query);
		while ($str = mysql_fetch_array($result, MYSQLI_NUM)) 
			echo '<tr><td><input type="checkbox" name="grtodel[]"' . "value=$str[1] /></td>" 
		. '<td><a href="../statistic/statist.php?shg=' . $str[1] . '&sht=' . $i .' ">' . $str[0] . "</a></td></tr>";
		return 0;
	}

	public function reggroups($array, $ts)
	{
		$w = true;
		$n = count($array);		// кількість нових груп для проходження				
		if ($n != 0)	// якщо був обрана хоч одина група для додавання
		{
		for ($i = 0; $i < $n; $i++)
		{
			$query = "SELECT * FROM testandgr WHERE idgroup = '$array[$i]' AND idtest = '$ts'";
			$result = $this -> mydb -> selectdata($query);
			$str = mysql_fetch_array($result);
			if ($str[0] == '') // якщо користувач вже не був зареєстрований у даній групі...
			{
				$query = "INSERT INTO testandgr (idgroup, idtest) VALUES('$array[$i]','$ts')";
				$this -> mydb -> insertdata($query);
			}
			else
				$w=false;
		}
		if ($w==true)
			myerror('Виконано..');
		else
			myerror('Деякі групи вже були підписані на даний тест..');
		}
		else
			myerror('Ви не обрали жодну групу..');
			return 0;
	}

	public function delgroups($array, $ts)
	{
		$n = count($array);		// кількість груп для видалення				
		if ($n != 0)	// якщо був обрана хоч одина група для видалення
		{
			for ($i = 0; $i < $n; $i++)
			{
				$query = "DELETE FROM testandgr WHERE idgroup = '$array[$i]' AND idtest = '$ts'";
				$result = $this -> mydb -> deldata($query);
			}
			myerror('Виконано..');
		}
		else
			myerror('Ви не обрали жодну групу..');
			return 0;
	}

	public function delquestion($idq)
	{
		$query = "DELETE FROM questions WHERE id = '$idq'";
		$result = $this -> mydb -> deldata($query);
		$query = "DELETE FROM answers1 WHERE qid = '$idq'";
		$result = $this -> mydb -> deldata($query);
		$query = "DELETE FROM answers2 WHERE qid = '$idq'";
		$result = $this -> mydb -> deldata($query);
		$query = "DELETE FROM answers3 WHERE qid = '$idq'";
		$result = $this -> mydb -> deldata($query);
		return 0;
	}

	public function deltest()
	{
		$i = $this -> tid;
		$query = "DELETE FROM tests WHERE id = '$i'";
		$result = $this -> mydb -> deldata($query);
		$query = "SELECT id FROM questions WHERE idtest = '$i'";
		$result = $this -> mydb -> selectdata($query);
		while ($str = mysql_fetch_array($result, MYSQLI_NUM))
			$this -> delquestion($str[0]);
		myerror('Виконано..');
		return 0;
	}

    public function getQuestionsId()
    {
        $questions = array();
        $tid = $this -> tid;
        $query = "SELECT id FROM questions WHERE idtest = $tid ";
        $result = $this -> mydb -> selectdata($query);
        while($str = mysql_fetch_array($result, MYSQLI_NUM))
            $questions[] = $str[0];
        return $questions;
    }

	public function getquestion($qid)
	{
		$id = $this -> tid;
		$cond = array();
		$answ = array();
		$query = "SELECT id, cond, qtype FROM questions WHERE idtest = $id AND id = $qid LIMIT 1";
		$result = $this -> mydb -> selectdata($query);
		$str = mysql_fetch_array($result, MYSQLI_NUM);
		$cond[0] = $str[0];
		$cond[1] = $str[1];
		$cond[2] = $str[2];
		switch ($cond[2]) 
		{
			case 1:
				$qid = $cond[0];
				$query = "SELECT id, answer FROM answers1 WHERE qid = $qid";
				$result = $this -> mydb -> selectdata($query);
				while ($str = mysql_fetch_array($result, MYSQLI_NUM))
					$answ[] = $str;
				$cond[3] = $answ;
			break;
			case 3:
				$an = array();
				$qid = $cond[0];
				$query = "SELECT id, answer FROM answers3 WHERE qid = $qid AND side = 1";
				$result = $this -> mydb -> selectdata($query);
				while ($str = mysql_fetch_array($result, MYSQLI_NUM))
					$an[] = $str;
				$answ[0] = $an;
				
				$an = array();

				$query = "SELECT id, answer FROM answers3 WHERE qid = $qid AND side = 0";
				$result = $this -> mydb -> selectdata($query);
				while ($str = mysql_fetch_array($result, MYSQLI_NUM))
					$an[] = $str;
				$answ[1] = $an;
				$cond[3] = $answ;
			break;
		}
		return $cond;
	}

	private function rofansw1($e)
	{

		$k = 0;
		$query = "SELECT id FROM answers1 WHERE qid = $e AND mright = 1";
		$result = $this -> mydb -> selectdata($query);
		while ($str = mysql_fetch_array($result, MYSQLI_NUM))
			$k++;
		return $k;
	}

	private function rofansw3($e)
	{
		$k = array();
		$kr = 0; $kl = 0;
		$query = "SELECT side FROM answers3 WHERE qid = $e";
		$result = $this -> mydb -> selectdata($query);
		while ($str = mysql_fetch_array($result, MYSQLI_NUM))
			if ($str[0] == 1)
				$kl++;
			else
				$kr++;
		$k[0] = $kl;
		$k[1] = $kr;
		return $k;				
	}

	public function gettar()
	{
		$tar = array();
		$tid = $this -> tid;
		$query = "SELECT cost1, cost2, cost3 FROM tests WHERE id = $tid";
		$result = $this -> mydb -> selectdata($query);
		$tar = mysql_fetch_array($result, MYSQLI_NUM);
		return $tar;
	}

	public function settar($tar)
	{
		$tid = $this -> tid;
		$query = "UPDATE tests SET cost1 = $tar[0], cost2 = $tar[1], cost3 = $tar[2] WHERE id = $tid";
		$this -> mydb -> update($query);
		return 0;
	}

	public function checkup()
	{
		$anws = $_SESSION['anws'];
		$sum = 0;
		$rum = 0;
		$tar = $this -> gettar();

		for ($i=0; $i < count($anws); $i++) 
		{ 
			$el = $anws[$i];
			switch ($el[0]) 
			{
			case 'log':
				// echo "LOG";
				$query = "SELECT answer FROM answers2 WHERE qid = $el[1]";
				$result = $this -> mydb -> selectdata($query);
				$str = mysql_fetch_array($result, MYSQLI_NUM);
				$ransw = $str[0];
				if ($ransw == $el[2])
					$sum = $sum + $tar[0];
				$rum = $rum + $tar[0];
				// echo "Q$el[1] R$ransw My$el[2] ! ";
				break;

			case 'stand':
				$rsum = $this -> rofansw1($el[1]);
				$ar = $el[2];
				$vsum = 0; $cor = 1;
				for ($j=0; $j < count($ar); $j++) 
				{ 
					$a = substr($ar[$j],3);

					$query = "SELECT mright FROM answers1 WHERE id = $a";
					$result = $this -> mydb -> selectdata($query);
					$str = mysql_fetch_array($result, MYSQLI_NUM);
					if ($str[0] == 1)
						$vsum++;
					else
						$cor=0;
				}
				// 
				if (($tar[1]*($vsum/$rsum*$cor)) == 1) $sum += 1;
				$rum = $rum + $tar[1];
				// echo "STAN";
				break;

			case 'comp':
					$vsum = 0;
					$k = $this -> rofansw3($el[1]);
					$kl = $k[0];
					$kr = $k[1];
					if ($kl < $kr)
						$rsum = $kl;
					else
						$rsum = $kr; ///кількість відношень які є пов'язаними
					
					$e = $el[2];
					$ucl = $e[0];
					$ucr = $e[1];

					for ($w=0; $w < count($ucl); $w++) 
					{ 
						$cl = $ucl[$w][0];
						$clc = $ucl[$w][1];
						if ($clc < 7)
						{
							$j = 0;
							$crc = $ucr[0][1];
							$cr = $ucr[0][0];
							while (($clc !== $crc) && ($j < count($ucr)))
								{ $j++; $cr=$ucr[$j][0]; $crc=$ucr[$j][1]; }
							// echo "________________$clc $cl---- $crc $cr ";
							if ($j<=$kl)
								$vsum++;
						}
					}
					// echo "_______________________________$vsum";
					$sum = $sum + $tar[2]*($vsum / $rsum);
					$rum = $rum + $tar[2];
					// echo "COMP";
				break;
			}
		}
		$_SESSION['shmark'] = $sum;
		return $sum / $rum;
	}

	public function getresult($uid)
	{
		$t = $this -> tid;
		$query = "SELECT mark, sdata FROM tsession WHERE iduser = $uid AND idtest = $t";
		$result = $this -> mydb -> selectdata($query);
		$a = array();
		while ($str = mysql_fetch_array($result))
			{ $a[]=$str[0]; $d=$str[1]; }
		$pkg[0] = $a;
		$pkg[1] = $d;
		return $pkg;
	}

	public function delresult($gid)
	{
		echo "Hi";
		$t = $this -> tid;
		$arofus = array();
		$query = "SELECT tsession.iduser FROM tsession INNER JOIN usandgr 
		ON usandgr.iduser = tsession.iduser WHERE usandgr.idgroup = $gid";
		$result = $this -> mydb -> selectdata($query);
		while ($str = mysql_fetch_array($result))
		{
			$query = "DELETE FROM tsession WHERE iduser = $str[0]";
			$this -> mydb -> deldata($query);
		}
		return 0;
	}

	public function getsub()
	{
		$n = $this -> tid;
		$query = "SELECT subjects.sname FROM subjects INNER JOIN tests ON tests.idsub = subjects.id WHERE tests.id = '$n'";
		$result = $this -> mydb -> selectdata($query);
		$str = mysql_fetch_array($result);
		$this -> tname = $str[0];
		return $str[0];
	}

	public function getname()
	{
		$n = $this -> tid;
		$query = "SELECT name FROM tests WHERE id = '$n'";
		$result = $this -> mydb -> selectdata($query);
		$str = mysql_fetch_array($result);
		$this -> tname = $str[0];
		return $str[0];
	}

	public function close()
	{
		$this -> mydb -> close();
		return 0;
	}
}
