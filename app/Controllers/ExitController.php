<?php
namespace App\Controllers;

use CodeIgniter\Controller;

class ExitController extends Controller
{
    public function UserExit(): void
    {
        $session = session();
        // 清除所有会话数据
        $session->destroy();
        // 将cookie有效期设为过期
        setcookie('959aca6b1338eead2254fa1d0c0b7827', '', time() - 3600);
    }
}
