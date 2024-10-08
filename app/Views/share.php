<?php
if (isset($file_share)) {

}else{
    return $this->response->setStatusCode(404)->setContent(json_encode(["code"=>404,"msg"=>"文件不存在"]));
}
?>
<!DOCTYPE html>
<html lang="zh-Hans">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $file_share['filename'];?>-YLiCloud云盘免费下载</title>
    <link href="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.bootcdn.net/ajax/libs/element-plus/2.7.3/index.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/share.css">
    <link rel="stylesheet" href="/css/global.css">
</head>

<body>
<!--弹窗信息-->
<div class="toast" id="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
    <div class="toast-header">
        <strong class="me-auto">系统通知</strong>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
        Null
    </div>
</div>
<!--导航栏-->
<nav class="navbar navbar-expand-lg bg-body-tertiary" style="flex: 1">
    <div class="container-fluid">
        <img src="/logo.png" alt="Bootstrap" width="105" height="60" class="d-inline-block align-text-top">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto fs-5 fw-semibold">
                <li class="nav-item ms-3">
                    <a class="nav-link" href="/">首页</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="#" onclick="location.reload()">分享</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/index">我的云盘</a>
                </li>
            </ul>
        </div>
        <button class="btn btn-primary float-end" type="button">
            <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
            共享中的文件
        </button>
    </div>
</nav>
<!--主体-->
<nav id="content">
    <div class="card text-center w-25 h-25">
        <div class="card-header">
            共享文件
        </div>
        <div class="card-body">
            <h5 class="card-title"><?php echo $file_share['filename'];?></h5>
            <p class="card-text">
                <?php
                if ($file_share['filesize'] < 1024 * 1024) {
                    echo round($file_share['filesize'] / 1024, 2) . "KB";
                } elseif ($file_share['filesize'] < 1024 * 1024 * 1024) {
                    echo round($file_share['filesize'] / (1024 * 1024), 2) . "M";
                } else {
                    echo round($file_share['filesize'] / (1024 * 1024 * 1024), 2) . "G";
                }
                ?>
            </p>
            <a href="#" class="btn btn-primary" onclick="menuItem('download','<?php echo $file_share['id'];?>')">下载</a>
        </div>
        <div class="card-footer text-muted">
            上传时间：<?php echo $file_share['filedate'];?>
        </div>
    </div>
</nav>
</body>
<script src="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.min.js"></script>
<script src="/js/menu.js"></script>
</html>