<?php
namespace crud\controllers;

use yii\web\Controller;

class ApiController extends Controller
{
    public function error($message, $data = [],$header=[])
    {
        header('Content-Type: application/json');
        return json_encode([
            'code' => 0,
            'message' => $message,
            'time' => time(),
            'data' => $data
        ]);
    }

    public function success($message, $data = [],$header=[])
    {
        header('Content-Type: application/json');
        return json_encode([
            'code' => 1,
            'message' => $message,
            'time' => time(),
            'data' => $data,
        ]);
    }

    public function Auth(){
        wp_set_auth_cookie();
        wp_clear_auth_cookie();
    }

    public function json($data){
        header('Content-Type: application/json');
        return json_encode($data);
    }

    public function html($data){
        header('Content-Type: application/json');
        return (string) $data;
    }
}