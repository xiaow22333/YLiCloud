<?php

namespace App\Models;

use CodeIgniter\Model;

class LoginModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'uid'; // 主键字段
    protected $allowedFields = ['uemail', 'upwd', 'udate']; // 允许的字段列表
    public function getUser($umail, $upwd): array
    {
        $loginSuccess = false; // 默认登录不成功
        $message = '注册成功,请登录';

        $search_user = $this->where(['uemail' => $umail])->first();
        if ($search_user) {
            if (password_verify($upwd, $search_user['upwd'])){
                session()->set('uid', $search_user['uid']);
                session()->set('uemail',$search_user['uemail']);
                session()->set('udate',$search_user['udate']);
                session()->set('ulv',$search_user['ulv']);
                $loginSuccess = true;
            } else {
                $message = "密码错误，请重试";
            }
        } else {
            //不存在用户
            $this->createUser($umail, $upwd);
        }
        return [
            'success' => $loginSuccess,
            'message' => $message,
            'reg' => false,
        ];
    }

    public function createUser($umail, $upwd): array
    {
        $hash_pwd = password_hash($upwd, PASSWORD_DEFAULT);
        try {
            $this->insert([
                'uemail' => $umail,
                'upwd' => $hash_pwd,
                'udate' => date('Y-m-d')
            ]);
        } catch (\ReflectionException $e) {
            echo "出现异常，请重试:", $e;
        }
        return [
            'success' => false,
            'message' => "注册成功,请登录",
            'reg' => true
        ];
    }
}