<!DOCTYPE html>
<html lang="zh-Hans">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>找回密码</title>
    <link href="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/login.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            width: 100vw;
        }

        .container {
            background-color: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 30vw;
            margin: 0;
        }

        .container h2 {
            margin-bottom: 15px;
        }

        .container form {
            display: flex;
            flex-direction: column;
        }

        .container form input {
            margin-bottom: 10px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .container form button {
            padding: 10px;
            border: none;
            border-radius: 6px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }

        .container form button:disabled {
            background-color: #ccc;
        }

        .message {
            margin-bottom: 10px;
            color: red;
        }

        .success {
            color: green;
        }
    </style>
</head>
<body>
<!--背景图-->
<img src="/resources/pics/index_bg.png" class="bg img-fluid" alt="index_bg">
<img src="/resources/pics/index_bg_md.png" class="bg img-fluid d-md-none" alt="index_bg_md">
<!--找回密码-->
<div class="container" style="padding: 0">
    <div class="container">
        <h2>找回密码</h2>
        <div class="message" id="message"></div>

        <!-- 发送验证码表单 -->
        <form id="sendForm">
            <input type="email" id="email" name="email" placeholder="请输入您的邮箱" required>
            <button type="button" id="sendButton" onclick="sendCode()">发送验证码</button>
        </form>

        <!-- 修改密码表单 -->
        <form id="resetForm" style="display: none;">
            <input type="text" id="reset_code" placeholder="请输入验证码" required>
            <input type="password" id="new_password" placeholder="请输入新密码" required>
            <button type="button" onclick="changePwd()">修改密码</button>
            <button type="button" onclick="resetForm()">返回</button>
        </form>
    </div>
    <script src="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.min.js"></script>
    <script>
        let countdown;

        function sendCode() {
            const email = document.getElementById('email').value;
            if (!email) {
                document.getElementById('message').innerText = '请输入您的邮箱';
                return;
            }
            fetch('/find/send', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({email: email})
            })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        document.getElementById('message').innerText = data.error;
                    } else {
                        document.getElementById('message').innerText = '验证码已发送到您的邮箱';
                        document.getElementById('sendForm').style.display = 'none';
                        document.getElementById('resetForm').style.display = 'block';
                        startTimer();
                    }
                });
        }

        function changePwd() {
            const email = document.getElementById('email').value;
            const resetCode = document.getElementById('reset_code').value;
            const newPassword = document.getElementById('new_password').value;
            if (!resetCode || !newPassword) {
                document.getElementById('message').innerText = '请填写所有字段';
                return;
            }
            fetch('/find/change', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({email: email, reset_code: resetCode, new_password: newPassword})
            })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        document.getElementById('message').innerText = data.error;
                    } else {
                        document.getElementById('message').innerText = '密码已成功更新';
                        document.getElementById('message').classList.add('success');
                        document.getElementById('resetForm').style.display = 'none';
                        startSuccessCountdown();
                    }
                });
        }

        function startTimer() {
            const button = document.getElementById('sendButton');
            button.disabled = true;
            let timeLeft = 60;
            countdown = setInterval(() => {
                timeLeft--;
                button.innerText = `请等待 ${timeLeft} 秒`;
                if (timeLeft <= 0) {
                    clearInterval(countdown);
                    button.disabled = false;
                    button.innerText = '发送验证码';
                }
            }, 1000);
        }

        function startSuccessCountdown() {
            let timeLeft = 5;
            const messageElement = document.getElementById('message');
            countdown = setInterval(() => {
                timeLeft--;
                messageElement.innerText = `密码已成功更新，${timeLeft} 秒后返回主页`;
                if (timeLeft <= 0) {
                    clearInterval(countdown);
                    window.location.href = '/';
                }
            }, 1000);
        }

        function resetForm() {
            document.getElementById('sendForm').style.display = 'block';
            document.getElementById('resetForm').style.display = 'none';
            document.getElementById('message').innerText = '';
            document.getElementById('message').classList.remove('success');
            if (countdown) {
                clearInterval(countdown);
                document.getElementById('sendButton').innerText = '发送验证码';
                document.getElementById('sendButton').disabled = false;
            }
        }
    </script>
</body>
</html>