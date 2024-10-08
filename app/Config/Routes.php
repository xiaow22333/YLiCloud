<?php

use CodeIgniter\Router\RouteCollection;
/**
 * @var RouteCollection $routes
 */
//登录注册路由
$routes->get('/', 'PagesController::view/login');
$routes->post('/','LoginController::login');
//找回密码路由
$routes->get('/find','PagesController::view/findpwd');
$routes->post('/find/send','FindPwdController::send');
$routes->post('/find/change','FindPwdController::changePwd');
//首页多项功能路由
$routes->group('index', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->get('/','PagesController::view/index');
    $routes->post('/',function (){
        redirect()->to('/');
    }); //中途掉线跳回登录页登录
    $routes->get('index','PagesController::indexload/index');
    $routes->get('recycle','PagesController::indexload/recycle');
    $routes->get('user','PagesController::indexload/user');
    $routes->get('about','PagesController::indexload/about');
});
//文件管理路由
$routes->group('files', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->post('upload','UploadFilesController::upload');//上传文件
    $routes->get('d/(:segment)','FileManagementController::menuItems/download/$1');//下载文件
    $routes->post('k/(:segment)','FileManagementController::menuItems/key/$1');//获取加密密钥
    $routes->get('s/(:segment)','FileManagementController::menuItems/share/$1');//分享文件页面
    $routes->post('r/(:segment)/(:segment)','FileManagementController::menuItems/rename/$1/$2');//重命名文件
    $routes->post('d1/(:segment)','FileManagementController::menuItems/delete/$1');//删除文件
    $routes->post('rec/(:segment)','FileManagementController::menuItems/rec/$1');//恢复文件
    $routes->post('d2/(:segment)','FileManagementController::menuItems/delete2/$1');//彻底删除文件
});
//服务条款
$routes->get('/term','PagesController::view/term');
//退出登录
$routes->post('/exit','ExitController::UserExit');
//登录过期
$routes->get('/expired','PagesController::view/expired');
//管理员页面路由
$routes->group('admin', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->get('login', 'PagesController::adminload/login');
    $routes->post('verify', 'PagesController::adminload/verify');
    $routes->get('index', 'PagesController::adminload/index',['filter' => 'admin']);
    $routes->group('api',['namespace' => 'App\Controllers','filter' => 'admin'], function ($routes) {
        $routes->get('home', 'AdminController::home');
        $routes->get('management', 'AdminController::management');
        $routes->get('feedback', 'AdminController::feedback');
    });
});