<?php

namespace app\controllers;

use app\models\Login;
use app\models\User;

class MainController extends AppController
{

    public function indexAction()
    {
        $menu = $this->menu;
        $this->setMeta('Главная страница', 'Описание страницы', 'Ключевые слова');
        $meta = $this->meta;
        $title = 'PAGE_TITLE';
        $this->set(compact('title','menu', 'meta'));
    }


    public function authAction ()
    {
        $login = new Login($_GET['login'], $_GET['pass']);

        if ($user = $login->begin()) {

            $result = [
                'status' => 'Ok',
                'token' => $user['token'],
                'username' => $user['username']
            ];
        }
        else {
            $result = [
                'status' => 'Not found',
                'token' => false,
                'username' => false
            ];
        }

        echo json_encode($result);
    }


    /**
     * @throws \Exception
     */
    public function getUserAction ()
    {
        $query = rtrim($_SERVER['QUERY_STRING'],'/');
        $query = explode('/', $query)[1];
        $query = explode('&', $query);
        $username = $query[0]; $token = explode('=', $query[1])[1];
        $user = User::getUser($username, $token);
        $user = array_merge(['status' => 'Ok'] , $user);

        echo json_encode($user);
    }


    /**
     * @throws \Exception
     */
    public function formUserAction ()
    {
        $this->layout = 'main';
        $title = 'Форма редактирования пользователя';
        $query = rtrim($_SERVER['QUERY_STRING'],'/');
        $query = explode('/', $query)[1];
        $query = explode('&', $query);
        $username = $query[0]; $token = explode('=', $query[1])[1];
        $user = User::getUserForm($username, $token);
        $this->set(compact('title','user'));
    }

}