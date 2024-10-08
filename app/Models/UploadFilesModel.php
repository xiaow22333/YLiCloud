<?php

namespace App\Models;

use CodeIgniter\Model;

class UploadFilesModel extends Model
{
    protected $table = 'files';
    protected $primaryKey = 'id'; // 主键字段
    protected $allowedFields = ['uid', 'filename', 'filedate', 'filesize', 'filepath','state','share']; // 允许的字段列表

    public function updates($id,$size): void
    {
        try {
            $this->update($id,[
                'filedate' => date("Y-m-d H:i:s"),
                'filesize' => $size,
            ]);
        } catch (\ReflectionException $e) {
            echo "出现异常，请重试:", $e;
        }
    }
    public function inserts($uid, $name, $size, $path): void
    {
        try {
            $this->insert([
                'uid'=>$uid,
                'filename' =>$name,
                'filedate' => date("Y-m-d H:i:s"),
                'filesize' => $size,
                'filepath'=>$path
            ]);
        } catch (\ReflectionException $e) {
            echo "出现异常，请重试:", $e;
        }
    }
}