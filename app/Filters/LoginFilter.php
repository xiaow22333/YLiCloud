<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class LoginFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->has('login')) {
            session()->setFlashdata('error', '用户登陆状态异常，请返回重新登陆');
            return redirect()->to('/expired');
        }
        return null;
    }
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}