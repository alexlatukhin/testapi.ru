<?php

namespace app\models;

use vendor\core\Db;

class Login
{
    public $login;
    public $pass;

    /**
     * Login constructor.
     * @param $login
     * @param $pass
     */
    public function __construct($login, $pass)
    {
        $this->login = $login;
        $this->pass = $pass;
    }

    /**
     * @return bool|mixed
     */
    public function begin()
    {
        // Получаем данные из БД
        $user = $this->getUser();
        // Если пользователь существует
        if ($user) {
            // Обновляем токен и возвращаем пользователя
            $user = $this->updateToken();
            return $user;
        }
        return false;
    }

    /**
     * @return mixed
     */
    private function updateToken()
    {
        // Обновляем токен
        $token = GeneratorRandomString::create();
        $db = Db::instance();
        $db->query("UPDATE `users` SET `token` = :token WHERE `login` = :login AND `pass` = :pass", [
            'token' => $token, 'login' => $this->login, 'pass' => $this->pass
        ]);
        // Возвращаем обновленного пользователя
        $user = $this->getUser();
        return $user;
    }

    /**
     * @return bool
     */
    private function getUser()
    {
        $db = Db::instance();
        $user = $db->query("SELECT `username`, `token` FROM `users` WHERE `login` = :login AND `pass` = :pass LIMIT 1", [
            'login' => $this->login, 'pass' => $this->pass
        ]);
        if ($user)
            return $user[0];
        return false;
    }
}