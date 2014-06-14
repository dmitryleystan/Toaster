<?php
session_start();

function userrights($right)
{
	$host = $_SERVER['HTTP_HOST'];
	switch ($right)
		{
			case 'admin':
				if ($_SESSION['rights'] != 'admins')
					header("Location: http://$host/index.php");
				break;
			case 'user':
				if ($_SESSION['rights'] != 'users')
					header("Location: http://$host/index.php");
				break;
		}
	return 0;
}

?>