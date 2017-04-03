<?php
ob_start();
session_start();
require_once "config.php";

spl_autoload_register(function($class){
   require_once './classes/' . $class . '.php';
});

$db = MainDB::getInstance();

require_once './functions/sanitize.php';
require_once './functions/general.php';
require_once './functions/manage.php';

if(Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))){
    $hash = Cookie::get(Config::get('remember/cookie_name'));
    $hashCheck = DB::getInstance()->get('users_session', array('hash', '=', $hash));

    if($hashCheck->count()){
        $user = new User($hashCheck->first()->user_id);
        $user->login();
    }
}
