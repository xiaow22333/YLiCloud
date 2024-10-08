<style>
    .jumbotron {
        background-color: #f8f9fa; /* 背景颜色 */
        border-radius: 0.5rem; /* 圆角 */
        padding: 4rem 2rem; /* 内边距 */
        margin-top: 3rem; /* 顶部外边距 */
        color: #333; /* 文字颜色 */
    }
    .rounded-list {
        list-style-type: none; /* 移除默认列表样式 */
        padding: 0;
    }
    .rounded-list li::before {
        line-height: 3rem; /* 解决列表项间距 */
        content: "•"; /* 添加实心圆点 */
        color: #007bff; /* 设置圆点颜色 */
        display: inline-block; /* 内联块级元素 */
        width: 1em; /* 圆点宽度 */
    }
    #about-title{
        font-family: 'Pacifico', cursive;
        transition: all 0.8s ease-in-out;
    }
    #about-title:hover{
        font-size: 80px;
        color: #ed9108;
    }
</style>
<div class="container">
    <div class="jumbotron jumbotron-bg">
        <h1 class="display-4" id="about-title">关于YLiCloud云盘</h1>
        <p class="lead">一个由大学生独立开发，基于PHP的个人云盘系统，致力于打造一个简单、易用、安全、免费的个人云盘服务。</p>
        <hr class="my-4">
        <ol class="rounded-list">
            <li><span class="fas fa-check">高速上传与下载，无论何时何地都能快速访问您的文件。</span></li>
            <li><span class="fas fa-check">端到端加密，确保您的数据安全无忧。</span></li>
            <li><span class="fas fa-check">智能文件管理，支持多文件备份。</span></li>
            <li><span class="fas fa-check">跨平台同步，支持PC、Mac、iOS和Android设备。</span></li>
            <li><span class="fas fa-check">灵活的分享选项，轻松与朋友和同事共享文件。</span></li>
        </ol>
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