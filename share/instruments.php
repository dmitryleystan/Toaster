<?php
session_start();
$host = $_SERVER['HTTP_HOST'];
function userrights($right)
{
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

function myerror($string)
{
echo '<p id="error">' . $string . '</p>';
return 0;
}
?>