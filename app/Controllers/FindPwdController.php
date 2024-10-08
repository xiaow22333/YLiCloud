<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\FindPwdModel;
use CodeIgniter\HTTP\ResponseInterface;

class FindPwdController extends Controller
{
    //发送邮件
    public function send()
    {
        $email = $this->request->getJSON()->email;
        $model = new FindPwdModel();
        //判断是否存在用户
        $user = $model->checkEmailExists($email);
        if (!$user) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)->setJSON(['error'=>"邮箱不存在"]);
        }
        // 生成验证码并设置过期时间
        $resetCode = rand(100000, 999999); // 生成6位验证码
        $expiry = time() + 300; // 验证码时效
        // 存储验证码和过期时间
        $model->storeResetCode($email, $resetCode, $expiry);
        //发送验证码
        $this->sendEmail($email,'YLiCloud重置密码', "您本次的验证码是：$resetCode,(时效5mins)");

        return $this->response->setJSON(['message'=>"验证码已发送到您的邮箱"]);
    }

    //修改密码
    public function changePwd()
    {
        $email = $this->request->getJSON()->email;
        $resetCode = $this->request->getJSON()->reset_code;
        $newPassword = $this->request->getJSON()->new_password;
        $model = new FindPwdModel();
        // 验证验证码
        if (!$model->validateResetCode($email,$resetCode)){
            return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)->setJSON(['error' => '无效的验证码或验证码已过期']);
        }
        // 更新密码
        $model->updatePassword($email,$newPassword);
        return $this->response->setJSON(['message' => '密码已成功更新']);
    }
    //发送邮件
    public function sendEmail($to, $subject, $message)
    {
        // 使用CodeIgniter的Email类来发送邮件
        $email = \Config\Services::email();
        $email->setTo($to);
        $email->setSubject($subject);
        $email->setMessage($message);
        try {
            $email->send();
        }catch (\Exception $e){
            var_dump($e);
        }
    }
}