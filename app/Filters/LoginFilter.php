<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class LoginFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!isset($_COOKIE['959aca6b1338eead2254fa1d0c0b7827']) || $_COOKIE['959aca6b1338eead2254fa1d0c0b7827'] != 'c4ca4238a0b923820dcc509a6f75849b') {
//            echo '<script>window.location.assign("localhost:8080/expired");window.location.reload();</script>';
//            header("Location: localhost:8080/expired");
            return redirect()->to('/expired');
//            exit();
        }
        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}