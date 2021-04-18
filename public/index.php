<?php

use vendor\core\Router;

error_reporting(-1);

$query = rtrim($_SERVER['QUERY_STRING'],'/');

define('WWW',__DIR__);  //точка входа index.php, где мы сейчас и находимся
define('ROOT',dirname(__DIR__));  // корень сайта
define('APP', dirname(__DIR__) . '/app'); //путь до папки app
define('CORE', dirname(__DIR__) . 'vendor/core'); //путь до папки core
define('LIBS', dirname(__DIR__) . '/vendor/libs');  //путь до папки libs
define('LAYOUT', 'default'); //дефолтное значение шаблона

require LIBS . '/functions.php';

//Автозагрузка классов
spl_autoload_register(function ($class){
    $file = ROOT . '/' . str_replace('\\', '/', $class) . '.php';

    if (is_file($file))
    {
        require $file;
    }
});


//Default routes
Router::add('^(?P<controller>[a-z-]+)/(?P<alyas>[0-9-]+)/?(?P<action>[a-z-]+)', ['controller' => 'User', 'action' => 'update']);
Router::add('^$', ['controller' => 'Main', 'action' => 'index']);
Router::add('^(?P<action>[a-z-]+)', ['controller' => 'Main', 'action' => 'auth']);
Router::add('^(?P<action>[a-z-]+)/?(?P<alyas>[a-z-]+)', ['controller' => 'Main', 'action' => 'get-user']);
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)$');

Router::dispatch($query);




