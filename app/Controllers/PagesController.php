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
    //首页读取数据
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
    //加载不同内容视图
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
                return view('/index/user', $data);
            case 'about':
                return view('/index/about', ['content' => 'Contact Content']);
            default:
                return 'Content not found';
        }
    }
    public function adminload($page = null){
        $db = \Config\Database::connect();
        $GetFilesModel = new GetFilesModel();
        switch ($page) {
            case 'login':
                return view('/admin/login');
            case 'verify':
                $key = $this->request->getJSON()->key;
                $verify = $db->query("SELECT pwd FROM admin_pwd WHERE pwd = ?", [$key])->getRow();
                if ($verify){
                    //setcookie('F0AFD6415EEE0C416AE2163F3D658E9A', '10D7AF7B73CCBFF8F6240611B5CF46D1', time() + 3600);
                    session()->set('admin', true);
                    return $this->response->setJSON(['code' => 200, 'msg' => "验证成功"]);
                }else{
                    return $this->response->setJSON(['code' => 500, 'msg' => "验证失败"]);
                }
            case 'index':
                return view('/admin/index');
        }
    }
}