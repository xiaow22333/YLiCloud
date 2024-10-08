<!DOCTYPE html>
<html lang="zh-Hans">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>未知登录</title>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        .alert-box {
            background-color: #f8d7da;
            color: #721c24;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            text-align: center;
        }

        .alert-box h1 {
            margin: 0 0 10px 0;
        }

        .alert-box button {
            padding: 10px 20px;
            margin-top: 20px;
            border: none;
            border-radius: 5px;
            background-color: #ff6b81;
            color: white;
            cursor: pointer;
            font-size: 16px;
        }

        .alert-box button:hover {
            background-color: #fa3e4c;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="alert-box">
        <h1>系统提示</h1>
        <p>您未登录或登录已过期，请返回首页登录。</p>
        <button onclick="window.location.href='/';">重新登录</button>
    </div>
</div>
</body>
</html>