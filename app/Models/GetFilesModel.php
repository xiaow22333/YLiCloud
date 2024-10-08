<?php

namespace App\Models;

use CodeIgniter\Model;

class GetFilesModel extends Model
{
    protected $table = 'files';
    protected $primaryKey = 'id'; // 主键字段
    protected $allowedFields = ['filename', 'filedate', 'filesize','filepath','state','share','share-key']; // 允许的字段列表
    public function getfile($uid,$page)
    {
        if ($page == "index"){
            $search_files = $this->where(['uid'=>$uid])->where(['state'=>'0'])->findAll();
            if ($search_files){
                return $search_files;
            }else{
                return false;
            }
        }
        if ($page == "recycle"){
            $search_files = $this->where(['uid'=>$uid])->where(['state'=>'1'])->findAll();
            if ($search_files){
                return $search_files;
            }else{
                return false;
            }
        }
    }
    public function getuserfiles($uid): array
    {
        $get_userfiles = $this->where(['uid'=>$uid])->findAll();
        return $get_userfiles;
    }
}