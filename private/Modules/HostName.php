<?php
$base_dir = realpath(dirname(__FILE__)  . $ds . '..') . $ds;
include_once("{$base_dir}config/app_config.php");

$config = Config::getConfig();
$host = $config['host'];