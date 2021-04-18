<?php

namespace app\models;

use vendor\core\base\Model;
use vendor\core\Db;

class User extends Model
{
    public $login;
    public $pass;
    public $token;
    public $username;
    public $name;
    public $active;
    public $blocked;
    public $created_at;
    public $id;
    public $permissions;


    /**
     * @param $username
     * @param $token
     * @return mixed
     * @throws \Exception
     */
    public static function getUser($username, $token)
    {
        $db = Db::instance();

        $user = $db->query("SELECT `active`,`blocked`,`created_at`,`id`,`name`,`permissions` FROM `users` WHERE `username` = :username AND `token` = :token LIMIT 1", [
            'username' => $username, 'token' => $token
        ])[0];

        if ($user) {

            if ($user['blocked'] == '1') $user['blocked'] = true;
            else $user['blocked'] = false;

            $array = [];
            $idsPermissions = explode(',', $user['permissions']);
            foreach (Permission::getPermissions() as $permission) {
                if (in_array($permission['id'], $idsPermissions)) {
                    $array[] = $permission;
                }
            }
            $user['permissions'] = $array;

            return $user;
        }
        throw new \Exception('Переданы некорректные параметры url-адреса');
    }


    /**
     * @param $username
     * @param $token
     * @return mixed
     * @throws \Exception
     */
    public static function getUserForm($username, $token)
    {
        $db = Db::instance();

        $user = $db->query("SELECT `active`,`blocked`,`id`,`name`,`permissions` FROM `users` WHERE `username` = :username AND `token` = :token LIMIT 1", [
            'username' => $username, 'token' => $token
        ])[0];

        if ($user) {

            if ($user['blocked'] == '1') $user['blocked'] = true;
            else $user['blocked'] = false;

            return $user;
        }
        throw new \Exception('Переданы некорректные параметры url-адреса');
    }


    /**
     * @param $id
     * @param $token
     * @return mixed
     */
    public static function update ($id, $token)
    {
        $db = Db::instance();

        $db->query("UPDATE `users` SET `active` = :active, `blocked` = :blocked, `name` = :name, `permissions` = :permissions WHERE `id` = :id AND `token` = :token", [
            'id' => $id, 'token' => $token, 'name' => $_POST['name'], 'active' => $_POST['active'], 'blocked' => $_POST['blocked'], 'permissions' => $_POST['permissions']
        ]);

        return $db->query("SELECT * FROM `users` WHERE `id` = :id AND `token` = :token", [
            'id' => $id, 'token' => $token
        ])[0];
    }

}