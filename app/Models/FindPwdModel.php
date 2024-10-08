<?php

namespace App\Models;

use CodeIgniter\Model;

class FindPwdModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'uid';
    protected $allowedFields = ['uemail', 'upwd','reset_code', 'reset_code_expiry','ulv','udate'];

    //判断是否存在用户
    public function checkEmailExists($email)
    {
        return $this->where('uemail', $email)->first();
    }

    // 存储重置验证码和过期时间
    public function storeResetCode($email, $resetCode, $expiry)
    {
        return $this->where('uemail', $email)->set(['reset_code' => $resetCode, 'reset_code_expiry' => $expiry])->update();
    }

    // 验证重置验证码
    public function validateResetCode($email, $resetCode)
    {
        $user = $this->where('uemail', $email)->first();
        if ($user && $user['reset_code'] === $resetCode && $user['reset_code_expiry'] > time()) {
            return true;
        }
        return false;
    }

    //更新密码
    public function updatePassword($email, $newPassword)
    {
        return $this->where('uemail', $email)->set(['upwd' => password_hash($newPassword, PASSWORD_DEFAULT)])->update();
    }

    //拿到用户信息
    public function getUserInfo($uid): object|array|null
    {
        $getuser = $this->where('uid', $uid)->first();
        return $getuser;
    }
}