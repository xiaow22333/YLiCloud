<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->has('admin')) {
            session()->setFlashdata('error', '未通过管理员验证');
            return redirect()->to('/expired');
        }
        return null;
    }
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {
    }
}
