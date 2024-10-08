<?php

namespace App\Controllers;
use App\Filters\LoginFilter;
use App\Models\FindPwdModel;
use App\Models\GetFilesModel;
use CodeIgniter\Controller;

class PagesController extends Controller
{
    public function view($page): string
    {
        if ($page == "index"){
            $this->index();
        }
        return view($page);
    }
    public function index(): ?string
    {
        //$uid=2;
        $uid = session('uid');
        $GetFilesModel = new GetFilesModel();
        $files = $GetFilesModel->getfile($uid,"index");
        if (!$files){
            return null;
        }else{
            return view('index', ['files' => $files]);
        }
    }
    public function indexload($contentId = null): string
    {
        $uid = session('uid');
        $GetFilesModel = new GetFilesModel();
        $FindPwdModel = new FindPwdModel();
        // 根据contentId加载不同的内容视图
        switch ($contentId) {
            case 'index':
                $files = $GetFilesModel->getfile($uid,$contentId);
                return view('/index/home', ['files' => $files]);
            case 'recycle':
                $recycle_files = $GetFilesModel->getfile($uid,$contentId);
                return view('/index/recycle', ['recycle_files' => $recycle_files]);
            case 'user':
                $user = $FindPwdModel->getUserInfo($uid);
                $user_files = $GetFilesModel->getuserfiles($uid);
                // 合并两个数组
                $data = [
                    'user' => $user,
                    'user_files' => $user_files
                ];
//                var_dump($data);
//                exit();
                return view('/index/user', $data);
            case 'about':
                return view('/index/about', ['content' => 'Contact Content']);
            default:
                return 'Content not found';
        }
    }
}