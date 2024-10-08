<?php

namespace App\Controllers;

use App\Models\FileManagementModel;

class FileManagementController extends BaseController
{
    public function menuItems($fc, $fid, $name=null)
    {
        $key = "jywy20010531xiaowang2024qpalzmhf";
        $iv = "xiaowang010531jy";
        $model = new FileManagementModel();

        switch ($fc) {
            case 'download':
                $is_user = $model->search_fid($fid);
                if (count($is_user) != 0) {
                    $filepath = $is_user['filepath'];
                    $state = $is_user['state'];
                    if ($state != 1) {
                        return $this->response->download($filepath, null);
                    }
                    return false;
                }
                break;
            case 'key':
                //$encrypted = openssl_encrypt($fid, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
                //$encoded = base64_encode( openssl_encrypt($fid, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv) );
                $encoded = rtrim(strtr(base64_encode(openssl_encrypt($fid, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv) ), '+/', 'AB'), '=');
                if ($model->share_file($fid,$encoded)) {
                    return $encoded;
                }
                break;
            case 'share':
                $encoded = $fid ."==";
                $encrypted = base64_decode($encoded);
                $decrypted = openssl_decrypt($encrypted, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);

                if ($decrypted === false) {
                    $error = openssl_error_string();
                    return view('share', ['file_share' => ['state' => 'decrypted出错', 'error' => $error]]);
                }

                $file_share = $model->search_fid($decrypted);
                if ($file_share && $file_share['share'] == 0 && $file_share['state'] == 0){
                    return view('share', ['file_share' => $file_share]);
                }else{
                    if ($file_share['share'] == 1){
                        return view('share', ['file_share' => ['state' => '该文件未分享']]);
                    }
                    if ($file_share['state'] == 1){
                        return view('share', ['file_share' => ['state' => '该文件已被删除']]);
                    }
                }
                break;
            case 'rename':
                $rename = $model->rename_file($fid, $name);
                if ($rename['success']) {
                    $newpath ='../writable/uploads/'.session('uid').'/'.$name;
                    if (rename($rename['oldpath'], $newpath)){
                        header('Content-Type: application/json');
                        http_response_code(200);
                        echo json_encode(['success' => true, 'message' => '文件重命名成功']);
                    }else{
                        header('Content-Type: application/json');
                        http_response_code(400);
                        echo json_encode(['success' => false, 'message' => '文件重命名失败']);
                    }
                }else{
                    header('Content-Type: application/json');
                    http_response_code(400);
                    echo json_encode(['success' => false, 'message' => '文件重命名失败']);
                }
                break;
            case 'delete':
                header('Content-Type: application/json');
                if ($model->delete1($fid)){
                    http_response_code(200);
                    return true;
                }else{
                    http_response_code(400);
                    return false;
                }
            case 'rec':
                if ($model->rec($fid)){
                    http_response_code(200);
                    return true;
                }
                http_response_code(400);
                return false;
            case 'delete2':
                $path = $model->search_path($fid);
                if (file_exists($path)){
                    if (unlink($path)){
                        $model->delete2($fid);
                        http_response_code(200);
                        return true;
                    }
                    http_response_code(400);
                    return false;
                }
                http_response_code(400);
                return false;
            default:
                return false;
        }
    }
}
