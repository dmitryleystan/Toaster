<?php
class Config
{
    static public function getConfig()
    {
        return $config = array(
            'dbname' => 'toaster',
            'username' => '<username>',
            'password' => '<password>',
            'host' => 'localhost',
        );
    }
}
