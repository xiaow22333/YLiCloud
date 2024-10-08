<?php

namespace App\Controllers;

use App\Models\LoginModel;
use CodeIgniter\Controller;
use CodeIgniter\Cookie\Cookie;

class LoginController extends Controller
{
//    登录or注册
    public function login(): string|\CodeIgniter\HTTP\RedirectResponse
    {
        $log_email = $_POST['log_email'];
        $log_pwd = $_POST['log_pwd'];
        //实例化模型
        $LoginModel = new LoginModel();
        $login = $LoginModel->getUser($log_email, $log_pwd);
        if ($login['reg']) {
            //注册成功
            session()->setFlashdata('create_suc', $login['message']);
            return view('login');
        }
        if ($login['success']) {
            //设置cookie，用于被中间件检测拦截,并设置过期时间为1小时，md5加密名称
            //setcookie('959aca6b1338eead2254fa1d0c0b7827', 'c4ca4238a0b923820dcc509a6f75849b', time() + 3600);
            session()->set('login', true);
            //登陆成功
            return redirect()->to('/index');
        } else {
            // 登录失败，显示错误消息并返回登录页面
            session()->setFlashdata('login_error', $login['message']);
            return view('login');
        }
    }
}