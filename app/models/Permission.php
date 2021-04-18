<?php

namespace app\models;


class Permission
{
    public $id;
    public $permission;

    public static function getPermissions ()
    {
        return $array = [
            ['id' => 1, 'permission' => 'comment'],
            ['id' => 2, 'permission' => 'upload photo'],
            ['id' => 3, 'permission' => 'add event']
        ];
    }
}