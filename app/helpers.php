<?php
<<<<<<< HEAD
function get_db_config()
{
    if (getenv('IS_IN_HEROKU')) {
        $url = parse_url(getenv("DATABASE_URL"));
        return $db_config = [
            'connection' => 'pgsql',
            'host' => $url["host"],
            'database'  => substr($url["path"], 1),
            'username'  => $url["user"],
            'password'  => $url["pass"],
        ];
    } else {
        return $db_config = [
            'connection' => env('DB_CONNECTION', 'mysql'),
=======

function get_db_config()
{
    if(getenv('IS_IN_HEROKU')){
        $url = perse_url(getenv("DATABASE_URL"));

        return $db_config = [
            'connection' => 'pgsql',
            'host' => url['host'],
            'database' => substr($url["path"], 1),
            'username' => $url["user"],
            'password' => $url["pass"],
        ];
    }else{
        return $db_config = [
            'connection' => env('DB_CONNECTION','mysql'),
>>>>>>> 5866415510aff0cf208ce83d7e5f37261f17c762
            'host' => env('DB_HOST', 'localhost'),
            'database'  => env('DB_DATABASE', 'forge'),
            'username'  => env('DB_USERNAME', 'forge'),
            'password'  => env('DB_PASSWORD', ''),
<<<<<<< HEAD
=======

>>>>>>> 5866415510aff0cf208ce83d7e5f37261f17c762
        ];
    }
}
