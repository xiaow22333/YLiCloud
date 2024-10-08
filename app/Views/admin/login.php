<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理后台登录</title>
    <script src="/js/gsap.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        *,
        *:before,
        *:after {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        body {
            margin: 0;
            height: 100vh;
            width: 100%;
            color: black;
            background: #2e2c2c;
            overflow: hidden;
            display: grid;
            place-content: center;
        }

        .login {
            border-radius: 30px;
            background: linear-gradient(145deg, #cbf0ec, #abcac7);
            box-shadow: 17px 17px 34px #adccc9,
                -17px -17px 34px #cff4f1;

            width: 45rem;
            height: 20rem;
            padding: 1rem;
            display: flex;
            align-items: center;
            justify-content: space-evenly;
            /*gap: 0.5rem;*/
        }

        .logintext {
            font-family: "Inter", serif;
            color: #6779f5;
            text-align: center;
            font-size: 2.3rem;
            font-weight: 500;
            margin-bottom: 1rem;
        }

        @property --anim {
            syntax: "<number>";
            inherits: true;
            initial-value: 0;
        }

        .field {
            background: #6779f5;
            border-radius: 0.75rem;
            position: relative;
            height: 2.5rem;
            --anim: 0;
            transition: --anim 500ms ease;
            background: linear-gradient(to right,
                    #6779f5 calc(clamp(0, (var(--anim) - 0.75) / 0.25, 1) * 33%),
                    transparent calc(clamp(0, (var(--anim) - 0.75) / 0.25, 1) * 33%),
                    transparent calc(100% - clamp(0, (var(--anim) - 0.75) / 0.25, 1) * 33%),
                    #6779f5 calc(100% - clamp(0, (var(--anim) - 0.75) / 0.25, 1) * 33%)),
                linear-gradient(to top,
                    transparent calc(15% + clamp(0, (var(--anim) - 0.65) / 0.1, 1) * 70%),
                    #202122 calc(15% + clamp(0, (var(--anim) - 0.65) / 0.1, 1) * 70%)),
                linear-gradient(to right,
                    transparent calc(50% - clamp(0, var(--anim) / 0.65, 1) * 50%),
                    #6779f5 calc(50% - clamp(0, var(--anim) / 0.65, 1) * 50%),
                    #6779f5 calc(50% + clamp(0, var(--anim) / 0.65, 1) * 50%),
                    transparent calc(50% + clamp(0, var(--anim) / 0.65, 1) * 50%)),
                linear-gradient(#202122, #202122);
        }

        .field:has(input:focus) {
            --anim: 1;
        }

        .field>.placeholder {
            pointer-events: none;
            position: absolute;
            inset: 0;
            display: grid;
            place-content: center;
            color: #7d8dff;
            font-family: "Inter", serif;
            transition: transform 500ms ease;
        }

        .field:has(input:focus)>.placeholder,
        .field:has(input:not(:placeholder-shown))>.placeholder {
            transform: translateY(-50%) scale(0.85)
        }

        .field>input {
            display: flex;
            align-items: center;
            padding-left: 1rem;
            color: white;
            position: absolute;
            inset: 0.125rem;
            border-radius: 0.625rem;
            border: none;
            outline: none;
            background: #202122
        }

        .loginbtn {
            margin-top: 0.5rem;
            background: radial-gradient(circle at center, #6779f5 calc(-50% + var(--anim) * 150%), #202122 calc(var(--anim) * 100%));
            border-radius: 0.75rem;
            position: relative;
            height: 3rem;
            display: grid;
            place-content: center;
            color: #7d8dff;
            font-family: "Inter", serif;
            --anim: 0;
            transition: --anim 500ms ease, color 500ms ease;
        }

        .loginbtn:hover {
            --anim: 1;
            color: white;
            cursor: pointer;
        }

        #canvas {
            min-width: 25%;
            max-width: 50%;
            /*flex: 0.3;*/
            background: transparent;
        }
    </style>
</head>

<body>
    <div class="login">
        <canvas id="canvas"></canvas>
        <div>
            <div class="logintext">YLiCloud</br>后台管理</div>
            <div class="field">
                <input type="text" placeholder="" id="key" name="key">
                <div class="placeholder">超级密钥</div>
            </div>
            <div id="error-message" style="color: red; margin-top: 5px; display: none;">请输入超级密钥</div>
            <div class="loginbtn" onclick="submitForm()">登陆</div>
        </div>
    </div>
    <!--调试密码-->
    <h1 style="color: red">
        <?php
        $conn = new mysqli('localhost', 'root', '000000', 'cloud');
        $result = $conn->query("SELECT pwd FROM admin_pwd WHERE id = 1");
        while ($row = $result->fetch_assoc()) {
            echo $row['pwd'] . "<br>";
        }
        $conn->close();
        ?>
    </h1>
</body>
<script>
    function submitForm() {
        const key = document.getElementById('key').value;
        const errorMessage = document.getElementById('error-message');
        // 检查是否为空
        if (key.trim() === "") {
            errorMessage.style.display = "block";
            errorMessage.innerText = "请输入超级密钥";
        } else {
            errorMessage.style.display = "none";
            // 使用 fetch 发送 POST 请求
            fetch('/admin/verify', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        key: key
                    }) // 将 key 作为 JSON 数据发送
                })
                .then(response => response.json()) // 将响应解析为 JSON
                .then(data => {
                    // console.log('响应数据:', data);
                    if (data.code === 200) {
                        errorMessage.innerText = data.msg;
                        errorMessage.style.display = "block";
                        location.href = '/admin/index';
                    } else {
                        errorMessage.innerText = data.msg;
                        errorMessage.style.display = "block";
                    }
                })
                .catch(error => {
                    console.error('请求失败:', error);
                });
        }
    }

    function showpwd() {

    }
</script>
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
    import {
        GLTFLoader
    } from 'gltfLoader';

    const gltfLoader = new GLTFLoader;
    const canvas = document.getElementById('canvas');
    const width = 200;
    const height = 300;
    // 创建场景
    const scene = new THREE.Scene();
    scene.background = null

    // 创建相机
    const camera = new THREE.PerspectiveCamera(75, width / height, 0.1, 10000);
    camera.position.set(0, 0, 0);

    // 创建渲染器
    const renderer = new THREE.WebGLRenderer({
        canvas: canvas,
        antialias: true,
        alpha: true
    });
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
        harddisk.position.set(0, 0, -3.5);
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

</html>