<!DOCTYPE html>
<html lang="zh-Hans">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>YLiCloud-登录</title>
    <link href="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/login.css">
</head>

<body>
<!--背景图-->
<img src="/resources/pics/index_bg.png" class="bg img-fluid" alt="index_bg">
<img src="/resources/pics/index_bg_md.png" class="bg img-fluid d-md-none" alt="index_bg_md">
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
<?php if (session('login_error')): ?>
    <script>
        const toast = document.getElementById('toast');
        toast.style.setProperty("display", "block", "important");
        toast.querySelector('.toast-body').innerHTML = "<?= session('login_error') ?>";
    </script>
<?php endif; ?>
<?php if (session('create_suc')): ?>
    <script>
        const toast = document.getElementById('toast');
        toast.style.setProperty("display", "block", "important");
        toast.querySelector('.toast-body').innerHTML = "<?= session('create_suc') ?>";
    </script>
<?php endif; ?>
<!--登录框-->
<div id="box">
    <canvas id="canvas"></canvas>
    <div id="login_box">
        <h2 style="color: white" class="mt-4 text-wrap"><strong><em
                        style="color:dodgerblue" ondblclick="location.href='/admin'">YLiCloud云盘</em></strong></h2>
        <p style="color: black;font-size: 13px">若<strong
                    style="color: orangered">未注册</strong>,将使用所填邮箱和密码注册
        </p>
        <form class="col-auto g-3 mt-3 mb-4" method="post">
            <div class="col-auto mb-3">
                <label for="log_email" class="visually-hidden">电子邮箱</label>
                <input type="email" class="form-control" name="log_email" id="log_email"
                       placeholder="请输入您的电子邮箱" required autocomplete>
            </div>
            <div class="col-auto mb-3">
                <label for="log_pwd" class="visually-hidden">密码</label>
                <input type="password" class="form-control" name="log_pwd" id="log_pwd" placeholder="请输入您的密码"
                       required autocomplete>
            </div>
            <div class="d-grid gap-2 d-flex justify-content-md-center align-items-center">
                <button type="button" class="btn btn-secondary btn-sm w-50 text-break text-wrap"
                        onclick="location.href='find'">忘记密码
                </button>
                <button type="submit" class="btn btn-primary btn-sm w-100 text-break text-wrap">登录/注册</button>
            </div>
        </form>
    </div>
</div>
<script src="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.min.js"></script>
<script type="importmap">
    {
      "imports": {
        "three": "/js/three/three.module.min.js",
        "gltfLoader": "/js/three/loaders/GLTFLoader.js",
        "OrbitControls":"/js/three/controls/OrbitControls.js"
      }
    }
</script>
<script type="module">
    import * as THREE from 'three';
    import {GLTFLoader} from 'gltfLoader';

    const gltfLoader = new GLTFLoader;
    const canvas = document.getElementById('canvas');
    const width = 190;
    const height = 340;
    // 创建场景
    const scene = new THREE.Scene();
    scene.background = null

    // 创建相机
    const camera = new THREE.PerspectiveCamera(75, width / height, 0.1, 10000);
    camera.position.set(0, 0, 0);

    // 创建渲染器
    const renderer = new THREE.WebGLRenderer({canvas: canvas, antialias: true, alpha: true});
    renderer.setSize(width, height);

    // 创建光照
    const ambientLight = new THREE.AmbientLight(0x404040);
    scene.add(ambientLight);

    const directionalLight = new THREE.DirectionalLight(0xffffff, 1);
    directionalLight.position.set(0, 1, 1).normalize();
    scene.add(directionalLight);

    // 加载模型
    gltfLoader.load('/resources/model/ssd_samsung_980_pro_1tb.glb', (gltf) => {
        const harddisk = gltf.scene;
        harddisk.position.set(0.1, 0.1, -3.6);
        scene.add(harddisk);

        let angle = 0;

        // 渲染循环
        function animate() {
            requestAnimationFrame(animate);
            angle += 0.015; // 控制旋转速度
            harddisk.rotation.y = angle;
            renderer.render(scene, camera);
        }

        animate();
    })
</script>
<script>
    document.querySelector('.btn-close').addEventListener('click', function () {
        const toastElement = document.getElementById('toast');
        toastElement.style.display = "none";
        bootstrap.Toast.getInstance(toastElement).hide();
    });
</script>
</body>
</html>