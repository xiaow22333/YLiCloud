<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class AdminController extends Controller{
    public function home(){
        return $this->response->setStatusCode(200)->setJSON(['message' => '页面1']);
    }
    public function management(){
        return $this->response->setStatusCode(200)->setJSON(['message' => '页面2']);
    }
    public function feedback(){
        return $this->response->setStatusCode(200)->setJSON(['message' => '页面3']);
    }
}