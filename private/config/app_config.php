<?php
class Config
{
    static public function getConfig()
    {
        return $config = array(
            'dbname' => 'mybd',
            'username' => 'ross',
            'password' => 'sunshine',
            'host' => 'toaster.my'
        );
    }
}