<?php
include_once("{$base_dir}config/app_config.php");

class CDataBase
{
	private

    $db;

    public

	function __construct()
	{
        $config = Config::getConfig();
		$this->db = mysql_connect('localhost', $config['username'], $config['password']) or die('Error connect');
		mysql_select_db($config['dbname'], $this->db);
		mysql_query("set names 'utf8'");
	}

	function close()
	{
		mysql_close($this->db);
		return 0;
	}
		
	function selectdata($query)
	{
		$result = mysql_query($query, $this->db) or die('error_SELECT: ' . mysql_error());
		return $result;
	}

	function insertdata($query)
	{
		mysql_query($query, $this->db) or die('error_INSERT: ' . mysql_error());
		return 0;
	}

	function deldata($query)
	{
		mysql_query($query, $this->db) or die('error_DELETE: ' . mysql_error());
		return 0;	
	}

	function update($query)
	{
		mysql_query($query, $this->db) or die('error_UPDATE: ' . mysql_error());
		return 0;						
	}
}
