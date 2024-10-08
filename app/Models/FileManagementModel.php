<?php

namespace App\Models;

use CodeIgniter\Model;

class FileManagementModel extends Model
{
    protected $table = 'files';
    protected $primaryKey = 'id'; // 主键字段
    protected $allowedFields = ['filename', 'filedate', 'filesize','filepath','state','share','share-key']; // 允许的字段列表
//    检测是否用户自己的文件
    function search_fid($fid): object|bool|array
    {
        $is_user = $this->where('id', $fid)->where('uid', session('uid'))->first();
        if (!$is_user){
            return false;
        }
        return $is_user;
    }
    function share_file($fid,$key): bool
    {
        $change_share = $this->where('id', $fid)->get()->getRow()->share;
        if ($change_share == 1){
            $this->where('id', $fid)->set(['share' => 0,'share-key'=>$key])->update();
            return true;
        }else{
            $this->where('id', $fid)->set(['share' => 1])->update();
            return true;
        }
    }
    function rename_file($fid,$newname): array
    {
        $search_oldpath = $this->where('id', $fid)->get()->getRow()->filepath;
        if ($this->where('id', $fid)->set(['filename' => $newname])->update() && $this->where('id', $fid)->set(['filepath' => substr(dirname($search_oldpath),0,strrpos(dirname($search_oldpath),'/') + 1).session('uid').'/'.$newname])->update()) {
            return ['success' => true,'oldpath' => $search_oldpath];
        }else{
            return ['success' => false];
        }
    }
    function delete1($fid): bool
    {
        $this->where('id', $fid)->set(['state' => 1])->update();
        return true;
    }
    function rec($fid): bool
    {
        $this->where('id', $fid)->set(['state' => 0])->update();
        return true;
    }
    function search_path($fid)
    {
        $search = $this->select('filepath')->where('id', $fid)->get()->getRow()->filepath;
        if(!$search){
            return false;
        }
        return $search;
    }
    function delete2($fid): bool
    {
        $this->where('id', $fid)->delete();
        return true;
    }
}