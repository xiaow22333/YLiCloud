<?php
$totalFileSize = 0; // 初始化总文件大小变量
$maxFileSize = 0; // 初始化最大文件大小变量
$maxFileName = ''; // 初始化最大文件名变量
$minFileSize = PHP_INT_MAX; // 初始化最小文件大小变量为最大可能的整数
$minFileName = ''; // 初始化最小文件名变量
if (!empty($user_files)) {
    // 使用 array_column 提取所有 'filesize' 值
    $fileSizes = array_column($user_files, 'filesize');
    // 使用 array_sum 计算所有文件大小的总和
    $totalFileSize = array_sum($fileSizes);
    foreach ($user_files as $file) {
        if ($file['filesize'] > $maxFileSize) {
            $maxFileSize = $file['filesize'];
            $maxFileName = $file['filename'];
        }
        if ($file['filesize'] < $minFileSize) {
            $minFileSize = $file['filesize'];
            $minFileName = $file['filename'];
        }
    }
    //单位转换
    function formatFileSize($size) {
        $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
        $unitIndex = 0;
        while ($size >= 1024 && $unitIndex < count($units) - 1) {
            $size /= 1024;
            $unitIndex++;
        }
        return round($size, 2) . ' ' . $units[$unitIndex];
    }
}
?>
<style>
    #user1,#user2{
        font-family: "楷体", sans-serif;
        transition: all 0.8s ease-in-out;
    }
    #user1:hover,#user2:hover{
        font-size: 40px;
        color: #ed0858;
    }
</style>
<div class="list-group">
    <a class="list-group-item list-group-item-action list-group-item-primary" aria-current="true">
        <h2 class="mb-1" id="user1">用户信息</h2>
        <?php if (!empty($user)): ?>
            <p class="mb-1">UID: <?= esc($user['uid']); ?></p>
            <p class="mb-1">Email: <?= esc($user['uemail']); ?></p>
            <p class="mb-1">注册日期: <?= esc($user['udate']); ?></p>
            <p class="mb-1">用户等级: <?php switch ($user['ulv']): case 1: echo "普通用户"; break; case 2: echo "VIP用户"; break; case 3: echo "SVIP用户"; break; default: echo "未知等级"; break; endswitch; ?></p>
            <p class="mb-1">操作: <button type="button" class="btn btn-light btn-sm text-center ms-1" onclick="location.href='<?= base_url('/find'); ?>'">修改密码</button></p>
        <?php endif; ?>
    </a>
    <a class="list-group-item list-group-item-action list-group-item-info">
        <h2 class="mb-1" id="user2">文件信息</h2>
        <?php if (!empty($user_files)): ?>
            <p class="mb-1">文件总数: <?= count($user_files); ?></p>
            <p class="mb-1">已用空间: <?= formatFileSize($totalFileSize); ?></p>
            <p class="mb-1">最大文件: <?= esc($maxFileName); ?> (<?= formatFileSize($maxFileSize); ?>)</p>
            <p class="mb-1">最小文件: <?= esc($minFileName); ?> (<?= formatFileSize($minFileSize); ?>)</p>
        <?php endif; ?>
    </a>
</div>
<footer style="background-color: #f8f9fa; padding: 1.5rem 5rem;color: #333; width: 93%;position: fixed; bottom: 0;right: 0;">
    <div style="width: 100%; padding: 0 15px; display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center;">
        <div style="display: flex; gap: 1rem;">
            <a href="mailto:1781160263@qq.com" style="color: inherit; text-decoration: none;">联系我们</a>
            <a onclick="fetchContent('about')" href="#" style="color: inherit; text-decoration: none;">关于我们</a>
            <a href="/term" style="color: inherit; text-decoration: none;">服务条款</a>
        </div>
        <div style="margin-top: 1rem;">
            &copy; 2024 YLiCloud云盘. All rights reserved.
        </div>
    </div>
</footer>