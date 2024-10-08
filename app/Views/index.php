<!DOCTYPE html>
<html lang="zh-Hans">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>YLiCloud云盘</title>
    <link href="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.bootcdn.net/ajax/libs/element-plus/2.8.0/index.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/index.css">
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
<div id="app">
    <!--全局右键菜单-->
    <div class="custom-context-menu" id="customContextMenu">
        <ul>
            <li onclick="menuItem('download',clickedElement.getAttribute('fid'))" id="downloadItem">下载</li>
            <li onclick="menuItem('share',clickedElement.getAttribute('fid'))" id="shareItem">分享</li>
            <li onclick="menuItem('key',clickedElement.getAttribute('k'))" id="share-key" style="display: none">查看分享链接</li>
            <li onclick="menuItem('rename',clickedElement.getAttribute('fid'))" id="renameItem" data-bs-toggle="modal" data-bs-target="#renameModal">重命名</li>
            <li onclick="menuItem('delete',clickedElement.getAttribute('fid'))" id="deleteItem">删除</li>
            <li onclick="menuItem('recovery',clickedElement.getAttribute('fid'))" id="recoveryItem" style="display: none">恢复文件</li>
        </ul>
    </div>
    <!--重命名模态框-->
    <div class="modal fade" id="renameModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">重命名文件</h1>
                    &nbsp;&nbsp;&nbsp;
                    <span class="text-danger">Tips:请注意保持文件后缀名不变</span>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" id="rename-form" action="">
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">原名:</label>
                            <span class="form-control" id="old-name"></span>
                        </div>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">现名:</label>
                            <input type="text" class="form-control" id="new-name" name="new-name" required>
                            <input type="hidden" name="fid" id="renamefile-fid" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                            <button type="submit" class="btn btn-primary">保存</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--菜单-->
    <!--<el-col :span="2">-->
    <el-menu
            default-active="1"
            class="sidebar el-menu-vertical-demo" id="menu" :collapse="isCollapse">
        <el-menu-item index="0" id="logo" class="el-menu-item">
            <img src="/logo.png" style="width: 100px" alt="logo">
        </el-menu-item>
        <el-menu-item index="1" id="index" class="el-menu-item">
            <el-icon>
                <Files/>
            </el-icon>
            <span>我的文件</span>
        </el-menu-item>
        <el-menu-item index="2" id="recycle" class="el-menu-item">
            <el-icon>
                <Delete/>
            </el-icon>
            <span>回收站</span>
        </el-menu-item>
        <el-menu-item index="3" id="user" class="el-menu-item">
            <el-icon>
                <User/>
            </el-icon>
            <span>个人中心</span>
        </el-menu-item>
        <el-menu-item index="4" id="about" class="el-menu-item">
            <el-icon>
                <Cpu/>
            </el-icon>
            <span>关于我们</span>
        </el-menu-item>
    </el-menu>
    <!--</el-col>-->
    <div id="right_box">
        <!--横栏-->
        <nav class="navbar" style="background-color: #ffffff;">
            <div class="container-fluid">
                <span class="navbar-brand">
                    <?php
                    $hour = (int)date('G');
                    if ($hour >= 5 && $hour < 7) {
                        echo "清晨好，" . "<span id='uel'>" .session('uemail')."</span>";
                    } elseif ($hour >= 7 && $hour < 12) {
                        echo "早上好，" . "<span id='uel'>" .session('uemail')."</span>";
                    } elseif ($hour >= 12 && $hour < 14) {
                        echo "中午好，" . "<span id='uel'>" .session('uemail')."</span>";
                    } elseif ($hour >= 14 && $hour < 17) {
                        echo "下午好，" . "<span id='uel'>" .session('uemail')."</span>";
                    } elseif ($hour >= 17 && $hour < 19) {
                        echo "傍晚好，" . "<span id='uel'>" .session('uemail')."</span>";
                    } elseif ($hour >= 19 && $hour < 22) {
                        echo "晚上好，" . "<span id='uel'>" .session('uemail')."</span>";
                    } else {
                        echo "凌晨了，早些休息吧，" . "<span id='uel'>" .session('uemail')."</span>";
                    }
                    ?>
                </span>
                <div class="d-grid gap-2 d-md-block">
                    <button type="button" class="btn btn-primary btn-sm me-2" id="uploadbtn" data-bs-toggle="modal"
                            data-bs-target="#staticBackdrop" style="margin-top: 0.4px;width: 70px" onclick="checkck()">
                        上传
                    </button>
                    <el-popconfirm title="确定退出？" @confirm="user_exit">
                        <template #reference>
                            <el-button type="danger" icon="SwitchButton">安全退出</el-button>
                        </template>
                    </el-popconfirm>
                </div>
                <!-- 上传窗口 -->
                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
                     tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">上传文件</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <form action="<?php echo base_url('/upload'); ?>" method="post"
                                  enctype="multipart/form-data">
                                <div class="modal-body">
                                    <input class="form-control" type="file" name="files[]" id="formFileMultiple"
                                           multiple>
                                    <!--进度条-->
                                    <div id="progressContainer">
                                        <div class="progress">
                                            <div id="progressBar" class="progress-bar" role="progressbar"
                                                 style="width: 0;" aria-valuenow="0" aria-valuemin="0"
                                                 aria-valuemax="100">等待上传
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <section>
                                    <span style="padding-left: 12px;font-size: 20px;color: orangered">上传须知：</span>
                                    <ol>
                                        <li>同名文件将被覆盖</li>
                                        <li>单次最多上次20个文件，每个文件最大不超过1GB</li>
                                        <li>请注意文件合法性，若发现非法文件将直接清除</li>
                                    </ol>
                                </section>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">关闭
                                    </button>
                                    <button type="button" onclick="prepareUpload()" class="btn btn-primary">提交
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <!--主体内容部分-->
        <section id="content">
            <div class="list-group">
                <?php if (!empty($files)) : ?>
                    <div class="ms-2 me-auto mt-2 d-flex flex-wrap" style="border-radius: 9px">
                        <?php for ($i = 0; $i < sizeof($files); $i++) : ?>
                            <a class="files list-group-item list-group-item-action list-group-item-light me-3 mb-2 mt-1 d-flex flex-column" fid="<?=$files[$i]["id"]?>" s="<?=$files[$i]["share"]?>" k="<?=$files[$i]["share-key"]?>" n="<?=$files[$i]["filename"]?>">
                                <span id="fname" class="fw-bold fs-6 text-truncate"><?= esc($files[$i]["filename"]); ?></span>
                                <time class="font-monospace" style="font-size: xx-small"><?= esc($files[$i]["filedate"]); ?></time>
                            </a>
                        <?php endfor; ?>
                    </div>
                <?php else : ?>
                    <div class="alert alert-warning" role="alert">
                        这里暂时没有文件哦
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </div>
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
<script src="https://cdn.bootcdn.net/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.7.2/axios.min.js"></script>
<script src="/js/vue.js"></script>
<script src="/js/element-plus.min.js"></script>
<script src="/js/element-plus-icons-vue.js"></script>
<script src="/js/OhMyLive2D.js"></script>
<script>
    const app = Vue.createApp({
        data() {
            return {
                isCollapse: false
            }
        },
        mounted() {
            this.updateIsCollapse();
            window.addEventListener('resize', this.updateIsCollapse);
        },
        beforeUnmount() {
            window.removeEventListener('resize', this.updateIsCollapse);
        },
        methods: {
            updateIsCollapse() {
                this.isCollapse = window.innerWidth < 880;
                document.getElementById("right_box").style.width = document.body.style.width + "px" - document.getElementById('menu').style.width + "px";
            },
            user_exit() {
                // 发起 POST 请求
                fetch('<?= base_url("/exit") ?>', {
                    method: 'POST'
                }).then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    // 成功后重定向到 login.php 页面
                    window.location.href = '<?= base_url("/") ?>';
                }).catch(error => {
                    console.error('Error:', error);
                });
            },
        }
    })
    for (const [key, component] of Object.entries(ElementPlusIconsVue)) {
        app.component(key, component)
    }
    app.use(ElementPlus)
    app.mount('#app')
</script>
<script>
    OML2D.loadOml2d({
        // 模型配置
        models: [
            {
                path: '/js/HK416-2-destroy/model.json',
                position: [-55, 100],
                scale: 0.07,
                motionPreloadStrategy: "ALL",
                stageStyle: {
                    width: 200,
                    height: 350
                }
            }
        ],
        // 菜单配置
        menus: {
            disable: true,
        },
        // 提示框配置
        tips: {
            idleTips: {
                wordTheDay(wordTheDayData) {
                    return `${wordTheDayData.hitokoto}`;
                }
            },
        }
    });
</script>
<script>
    // 上传文件
    let filesToUpload = [];
    let xhr;

    function prepareUpload() {
        const files = document.querySelector('input[type="file"]').files;
        if (files.length === 0 || files.length > 20) {
            alert('请选择1-20个文件进行上传');
            return;
        }
        filesToUpload = Array.from(files); // 转换为数组
        document.getElementById('progressContainer').style.visibility = 'visible'; // 显示进度条
        document.getElementById('progressBar').style.width = '0%'; // 重置进度条
        uploadNextFile();
    }

    function uploadNextFile() {
        if (filesToUpload.length === 0) {
            document.getElementById('progressBar').textContent = '上传成功！'; // 重置进度条文本
            // alert('所有文件上传完成');
            return;
        }

        const file = filesToUpload.shift(); // 现在可以正常使用shift
        const formData = new FormData();
        formData.append('files[]', file); // 确保name属性与后端一致

        xhr = new XMLHttpRequest();
        xhr.open('POST', '<?php echo base_url('files/upload'); ?>', true);

        xhr.upload.onprogress = function (event) {
            if (event.lengthComputable) {
                const percentComplete = (event.loaded / event.total) * 100;
                document.getElementById('progressBar').style.width = percentComplete + '%'; // 设置进度条的宽度
                document.getElementById('progressBar').textContent = Math.round(percentComplete) + '%'; // 显示百分比
            }
        };

        xhr.onload = function () {
            if (this.status === 200) {
                console.log('文件上传成功');
                fetchContent('index'); //刷新文件列表
            } else {
                console.error('文件上传失败');
            }
            uploadNextFile(); // 继续上传下个文件
        };
        xhr.send(formData);
    }
    //已分享文件边框
    function sharefile_border() {
        const links = document.querySelectorAll('.files');
        links.forEach(link => {
            const shareValue = link.getAttribute('s');
            if (shareValue === '0') {
                link.classList.add('rainbow-border');
            } else {
                link.classList.remove('rainbow-border');
            }
        });
    }
</script>
<script>
    // 获取所有的菜单链接
    document.querySelectorAll('.el-menu-item').forEach(item => {
        item.addEventListener('click', function (e) {
            e.preventDefault();
            // 根据点击的链接ID获取内容ID
            let contentId = this.id;
            if (contentId === 'logo'){
                return;
            }
            // 发送AJAX请求
            fetchContent(contentId);
        });
    });

    // AJAX请求函数
    function fetchContent(contentId) {
        fetch(`<?= base_url("index/") ?>${contentId}`)
            .then(response => response.text())
            .then(html => {
                document.getElementById('content').style.animation = 'fadeOut 0.6s';
                // 等待淡出动画完成
                setTimeout(() => {
                    // 将新内容设置到#content元素
                    document.getElementById('content').innerHTML = html;
                    // 触发淡入动画
                    document.getElementById('content').style.animation = 'fadeIn 0.6s forwards';
                    sharefile_border()
                }, 450);
            })
            .catch(error => console.error('Error:', error));
    }
    window.onload = function () {
        sharefile_border()
    }
</script>
<script>
    function checkck() {
        if (hasCookie('959aca6b1338eead2254fa1d0c0b7827')) {
        } else {
            // 如果不存在，不执行后续操作
            alert('登录已过期');
            window.location.assign("http://localhost:8080/expired");
        }
    }
    function hasCookie(name) {
        const cookieArray = document.cookie.split(';');
        for(var i = 0; i < cookieArray.length; i++) {
            const cookiePair = cookieArray[i].split('=');
            // 去除cookie名称前后的空白字符
            const cookieName = cookiePair[0].trim();
            if (cookieName === name) {
                return true;
            }
        }
        return false;
    }
</script>
<script src="/js/menu.js"></script>
</body>
</html>
