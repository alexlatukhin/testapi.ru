<?php


namespace app\controllers;

use app\models\User;

class UserController extends AppController
{

    public function updateAction ()
    {
        $query = rtrim($_SERVER['QUERY_STRING'],'/');
        $id = explode('/', $query)[1];
        $token = explode('=', $query)[1];
        $update = User::update($id, $token);
        $status = isset($update) ? ['status' => 'Ok'] : ['status' => 'Error'];
        echo json_encode($status);
    }
}