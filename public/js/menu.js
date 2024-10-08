let clickedElement = null;

// 提示框关闭
document.querySelector('.btn-close').addEventListener('click', function () {
    const toastElement = document.getElementById('toast');
    toastElement.style.display = "none";
    bootstrap.Toast.getInstance(toastElement).hide();
});

document.addEventListener('contextmenu', function (event) {
    // 检查是否在类名为 "files" 的元素上右键点击
    if (event.target.closest('.files')) {
        event.preventDefault();  // 阻止默认右键菜单

        clickedElement = event.target.closest('.files');  // 记录被点击的元素
        // 是否分享
        if (clickedElement.getAttribute('s') == 0) {
            document.getElementById('shareItem').innerHTML = "取消分享";
            document.getElementById('share-key').style.display = "block";
        } else {
            document.getElementById('shareItem').innerHTML = "分享";
            document.getElementById('share-key').style.display = "none";
        }
        // 区分不同页面菜单功能
        if (clickedElement.hasAttribute('recycle')) {
            document.getElementById('deleteItem').innerHTML = "彻底删除";
            // document.getElementById('deleteItem').onclick = null;
            // document.getElementById('deleteItem').onclick = function() {
            //     menuItem('delete2',clickedElement.getAttribute('fid'))
            // };
            document.getElementById('recoveryItem').style.display = 'block';
            document.getElementById('shareItem').style.display = 'none';
            document.getElementById('renameItem').style.display = 'none';
            document.getElementById('downloadItem').style.display = 'none';
        } else {
            document.getElementById('deleteItem').innerHTML = "删除";
            document.getElementById('recoveryItem').style.display = 'none';
            document.getElementById('shareItem').style.display = 'block';
            document.getElementById('renameItem').style.display = 'block';
            document.getElementById('downloadItem').style.display = 'block';
        }
        const menu = document.getElementById('customContextMenu');
        // 显示菜单
        menu.style.top = `${event.clientY}px`;
        menu.style.left = `${event.clientX}px`;
        menu.style.display = 'block';

        document.addEventListener('click', function () {
            menu.style.display = 'none';
        }, {once: true});
    }
});

// 功能事件
function menuItem(fc, fid) {
    const xhr = new XMLHttpRequest();
    const toast = document.getElementById('toast');
    switch (fc) {
        case 'download':
            xhr.open('GET', '/files/d/' + fid);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    const a = document.createElement('a');
                    a.style.display = 'none';
                    a.href = '/files/d/' + fid;
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                    toast.style.setProperty("display", "block", "important");
                    toast.querySelector('.toast-body').innerHTML = "请求下载成功";
                } else {
                    toast.style.setProperty("display", "block", "important");
                    toast.querySelector('.toast-body').innerHTML = "请求下载失败";
                }
            }
            xhr.send();
            break;
        case 'share':
            xhr.open('POST', '/files/k/' + fid);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    toast.style.setProperty("display", "block", "important");
                    if (clickedElement.getAttribute('s') == 0) {
                        toast.querySelector('.toast-body').innerHTML = "已取消分享，链接失效";
                        fetchContent('index'); //刷新文件列表
                    } else {
                        const link = "localhost:8080/files/s/" + xhr.response;
                        toast.querySelector('.toast-body').innerHTML = "分享链接：" + link;
                        fetchContent('index'); //刷新文件列表
                    }
                }
            }
            xhr.send();
            break;
        case 'key':
            toast.style.setProperty("display", "block", "important");
            toast.querySelector('.toast-body').innerHTML = "localhost:8080/files/s/" + fid;
            break;
        case 'rename':
            document.getElementById("renamefile-fid").value = clickedElement.getAttribute("fid");
            document.getElementById("old-name").innerHTML = clickedElement.getAttribute("n");
            document.getElementById("new-name").value = clickedElement.getAttribute("n");
            break;
        case 'delete':
            if (clickedElement.hasAttribute('state')) {
                xhr.open('POST', '/files/d2/' + fid);
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        console.log(xhr.response);
                        toast.style.setProperty("display", "block", "important");
                        toast.querySelector('.toast-body').innerHTML = "文件已彻底删除";
                        fetchContent('recycle'); //刷新文件列表
                    } else {
                        toast.style.setProperty("display", "block", "important");
                        toast.querySelector('.toast-body').innerHTML = "删除失败，请重试";
                    }
                }
                xhr.send();
                break;
            } else {
                xhr.open('POST', '/files/d1/' + fid);
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        toast.style.setProperty("display", "block", "important");
                        toast.querySelector('.toast-body').innerHTML = "文件已移至回收站";
                        fetchContent('index'); //刷新文件列表
                    } else {
                        toast.style.setProperty("display", "block", "important");
                        toast.querySelector('.toast-body').innerHTML = "删除失败，请重试";
                    }
                }
                xhr.send();
                break;
            }
        case 'recovery':
            xhr.open('POST', '/files/rec/' + fid);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    toast.style.setProperty("display", "block", "important");
                    toast.querySelector('.toast-body').innerHTML = "文件已恢复";
                    fetchContent('recycle'); //刷新文件列表
                } else {
                    toast.style.setProperty("display", "block", "important");
                    toast.querySelector('.toast-body').innerHTML = "恢复失败，请重试";
                }
            }
            xhr.send();
            break;
        default:
            toast.style.setProperty("display", "block", "important");
            toast.querySelector('.toast-body').innerHTML = "未知错误";
            throw new Error('非法类型');
    }
}

// 重命名提交表单
document.getElementById('rename-form').onsubmit = function (e) {
    e.preventDefault();
    const fid = document.getElementById("renamefile-fid").value;
    const newname = document.getElementById("new-name").value;
    if (newname == '' || newname == document.getElementById("old-name").innerHTML) {
        toast.style.setProperty("display", "block", "important");
        toast.querySelector('.toast-body').innerHTML = "文件名不能为空或与原文件名相同";
    } else {
        // 构建请求的 URL 和请求体
        let actionUrl = '/files/r/' + encodeURIComponent(fid) + '/' + encodeURIComponent(newname);
        let formData = new FormData();
        formData.append('fid', fid);
        formData.append('newname', newname);
        fetch(actionUrl, {
            method: 'POST',
            body: formData,
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // 后端处理成功，提示用户
                    toast.style.setProperty("display", "block", "important");
                    toast.querySelector('.toast-body').innerHTML = "修改成功";
                    $('#renameModal').modal('hide');
                    fetchContent('index'); //刷新文件列表
                } else {
                    // 后端处理失败，提示用户错误信息
                    toast.style.setProperty("display", "block", "important");
                    toast.querySelector('.toast-body').innerHTML = "修改失败，请重试";
                }
            })
            .catch(error => {
                // 请求失败，提示用户网络错误或其他错误
                alert('请求失败，请稍后重试。');
                console.error('Error:', error);
            });
    }
};