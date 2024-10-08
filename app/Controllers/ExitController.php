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
    }
}
