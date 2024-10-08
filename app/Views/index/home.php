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