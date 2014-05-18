<?php
	class database
		{
			private $db;

			public function __construct($user,$password)
				{
					$this->db = mysql_connect('localhost',$user,$password) or die('Error connect');
					mysql_select_db('mybd', $this->db);
					mysql_query("set names 'utf8'");
				}

			public function close()
				{
					mysql_close($this->db);
					return 0;
				}
				
			public function selectdata($query)
				{
					$result = mysql_query($query, $this->db) or die('error_SELECT: ' . mysql_error());
					return $result;
				}

			public function insertdata($query)
				{
					mysql_query($query, $this->db) or die('error_INSERT: ' . mysql_error());
					return 0;
				}

			public function deldata($query)
				{
					mysql_query($query, $this->db) or die('error_DELETE: ' . mysql_error());
					return 0;	
				}

			public function update($query)
				{
					mysql_query($query, $this->db) or die('error_UPDATE: ' . mysql_error());
					return 0;						
				}
		}
?>