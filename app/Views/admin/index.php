<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YLiCloud后台管理</title>
    <link href="https://cdn.bootcdn.net/ajax/libs/element-plus/2.8.0/index.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .el-aside {
            background-color: #2d3a4b;
            color: #fff;
            width: 200px;
            float: left;
            height: 100vh;
        }
        .el-menu-item {
            padding: 15px;
            color: #fff;
            cursor: pointer;
        }
        .el-menu-item:hover {
            background-color: #1f2a36;
        }
        .el-menu-item.active {
            background-color: #1f2a36;
        }
        .el-main {
            background-color: #f5f5f5;
            padding: 20px;
            margin-left: 200px; /* 与左侧菜单宽度一致 */
        }
        h2 {
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }
        .loading {
            font-size: 18px;
            color: #888;
        }
        .error {
            color: red;
        }
        .statistic {
            display: flex;
            justify-content: space-between;
        }
        .statistic div {
            background: #fff;
            border: 1px solid #e4e4e4;
            border-radius: 4px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 30%;
        }
        .table {
            background: #fff;
            border: 1px solid #e4e4e4;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 20px;
        }
        .table table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            border: 1px solid #e4e4e4;
            padding: 10px;
            text-align: left;
        }
        .table th {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
<div class="el-aside">
    <div class="el-menu-item active" data-index="1">首页</div>
    <div class="el-menu-item" data-index="2">用户管理</div>
    <div class="el-menu-item" data-index="3">反馈管理</div>
</div>

<div class="el-main">
    <h2 id="current-page">首页</h2>
    <div id="content"></div>
</div>

<script>
    const statisticData = {
        userCount: 1128,
        orderCount: 215,
        income: 21340,
    };

    const defaultTableData = [
        { name: 'User1', email: 'user1@example.com', status: 'Active' },
        { name: 'User2', email: 'user2@example.com', status: 'Inactive' }
    ];

    const menuItems = document.querySelectorAll('.el-menu-item');
    const contentDiv = document.getElementById('content');
    const currentPageTitle = document.getElementById('current-page');

    const showDashboard = () => {
        currentPageTitle.innerText = '首页';
        contentDiv.innerHTML = `
            <div class="statistic">
                <div>
                    <h3>用户数</h3>
                    <p>${statisticData.userCount}</p>
                </div>
                <div>
                    <h3>订单数</h3>
                    <p>${statisticData.orderCount}</p>
                </div>
                <div>
                    <h3>收入</h3>
                    <p>¥${statisticData.income}</p>
                </div>
            </div>
        `;
    };

    const showTable = () => {
        currentPageTitle.innerText = '用户管理';
        contentDiv.innerHTML = `
            <div class="table">
                <table>
                    <thead>
                        <tr>
                            <th>用户名</th>
                            <th>邮箱</th>
                            <th>状态</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${defaultTableData.map(user => `
                            <tr>
                                <td>${user.name}</td>
                                <td>${user.email}</td>
                                <td>${user.status}</td>
                            </tr>
                        `).join('')}
                    </tbody>
                </table>
            </div>
        `;
    };

    const showFeedback = () => {
        currentPageTitle.innerText = '反馈管理';
        contentDiv.innerHTML = `
            <div class="table">
                <table>
                    <thead>
                        <tr>
                            <th>用户名</th>
                            <th>邮箱</th>
                            <th>反馈内容</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${defaultTableData.map(user => `
                            <tr>
                                <td>${user.name}</td>
                                <td>${user.email}</td>
                                <td>Great service!</td>
                            </tr>
                        `).join('')}
                    </tbody>
                </table>
            </div>
        `;
    };

    const handleMenuClick = (index) => {
        menuItems.forEach(item => item.classList.remove('active'));
        menuItems[index - 1].classList.add('active'); // index 是从 1 开始的
        switch (index) {
            case '1':
                showDashboard();
                break;
            case '2':
                showTable();
                break;
            case '3':
                showFeedback();
                break;
        }
    };

    menuItems.forEach(item => {
        item.addEventListener('click', () => {
            handleMenuClick(item.getAttribute('data-index'));
        });
    });

    // 默认显示首页
    showDashboard();
</script>
</body>
</html>
