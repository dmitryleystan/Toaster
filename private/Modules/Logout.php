<?php
session_start();
$host = $_SERVER['HTTP_HOST'];
$_SESSION = array();
if (isset($_COOKIE[session_name()]))
		setcookie(session_name(),'', time() - 3600);

session_destroy();
header("Location: http://$host/index.php");
