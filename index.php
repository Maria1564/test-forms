<?php
session_start();

require_once "./src/helpers/index.php";

$errorKey = $_GET['error'] ?? null;
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="login-form">
        <div class="login-form__wrapper">
            <h2 class="title">Вход</h2>

            <form action="./src/actions/login_user.php" method="post" class="form">
                <input
                    type="text"
                    name="login"
                    id="login"
                    required
                    value="<?= $_SESSION['temp_data']['login'] ?? '' ?>"
                    placeholder="email or phone"
                    class="input" />
                <input
                    type="password"
                    name="password"
                    id="password"
                    minlength="6"
                    required
                    placeholder="password"
                    class="input" />
                <?php if ($errorKey): ?>
                    <div style="color: #a94442; font-weight: 800; text-align: center;">
                        <?= get_error_message($errorKey) ?>
                    </div>
                <?php endif; ?>
                <button type="submit" class="btn">Войти</button>
            </form>

            <p class="login-form__text">Нет аккаунта? <a href="/register.php" class="link">Зарегестрироваться</a></p>
        </div>
    </div>


</body>

</html>