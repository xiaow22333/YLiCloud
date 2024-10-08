<?php

namespace App\Controllers;

use App\Models\UploadFilesModel;
use CodeIgniter\Controller;

class UploadFilesController extends Controller
{
    public function upload(): \CodeIgniter\HTTP\ResponseInterface
    {
        // 基础上传路径
        $upload_base_path = '../writable/uploads';
        $max_size = 1073741824; // 1GB
        $files = $this->request->getFileMultiple('files');

        // 获取用户ID
        $user_id = session('uid');

        // 检查并创建用户专属文件夹
        $user_folder_path = $upload_base_path . '/' . $user_id;
        if (!is_dir($user_folder_path)) {
            if (!mkdir($user_folder_path, 0777, true)) {
                return $this->response->setJSON(['message' => '无法创建用户文件夹'])->setStatusCode(500);
            }
        }

        if (sizeof($files) > 20) {
            return $this->response->setJSON(['message' => '文件数量超过20，无法上传'])->setStatusCode(400);
        } else {
            foreach ($files as $file) {
                // 检查文件是否有效
                if ($file->isValid()) {
                    $file_path = $user_folder_path . '/' . $file->getClientName();
                    // 检查文件大小是否超过1GB
                    if ($file->getSize() > $max_size) {
                        return $this->response->setJSON(['message' => '文件超过1GB，无法上传'])->setStatusCode(400);
                    }
                    // 如果文件存在，则删除已存在的文件
                    if (file_exists($file_path)) {
                        if (!unlink($file_path)) {
                            return $this->response->setJSON(['message' => '覆盖文件失败'])->setStatusCode(400);
                        }
                    }
                    // 上传文件并覆盖同名文件
                    if ($file->move($user_folder_path, $file->getClientName())) {
                        $model = new UploadFilesModel();
                        $existingFile = $model->where(['uid' => $user_id, 'filename' => $file->getClientName()])->first();
                        if ($existingFile){
                            $model->updates($existingFile['id'],$file->getSize());
                        }else{
                            $model->inserts($user_id,$file->getClientName(),$file->getSize(),$user_folder_path.'/'.$file->getClientName());
                        }
                        return $this->response->setJSON(['message' => '上传成功'])->setStatusCode(200);
                    } else {
                        return $this->response->setJSON(['message' => '上传失败'])->setStatusCode(400);
                    }
                } else {
                    return $this->response->setJSON(['message' => '非法文件'])->setStatusCode(400);
                }
            }
            return $this->response->setJSON(['message' => '上传成功'])->setStatusCode(200);
        }
    }
}
