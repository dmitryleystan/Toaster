Toaster
=======

system for testing students
Pro tempore only Ukraine local
Also critically need to be upgrade

Based on clean php+html+javascript
Can be runed on Apache2 and MySQL Database

To start using you need already initialized database
and edit config/app_config like:

        ...
        return $config = array(
            'dbname' => '<your DB name>',
            'username' => '<root db user>',
            'password' => '<root db password>',
            'host' => '<your host>'
        );
        ...