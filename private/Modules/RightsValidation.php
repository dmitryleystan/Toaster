<?php
function userrights($right)
{
    global $host;
	switch ($right)
		{
			case 'admin':
				if ($_SESSION['rights'] != 'admins')
                {
                    echo "hi";
					header("Location: http://$host/index.php");
                }
				break;
			case 'user':
				if ($_SESSION['rights'] != 'users')
					header("Location: http://$host/index.php");
				break;
		}
	return 0;
}


