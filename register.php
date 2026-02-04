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
  <div class="register-form">
    <div class="register-form__wrapper">
      <h2 class="title">Регистрация</h2>
      <form action="./src/actions/register_user.php" method="post" class="form">
        <input
          type="text"
          name="username"
          id="username"
          required
          value="<?= $_SESSION['temp_data']['username'] ?? '' ?>"
          placeholder="your username"
          class="input" />
        <input
          type="email"
          name="email"
          id="email"
          required
          value="<?= $_SESSION['temp_data']['email'] ?? '' ?>"
          placeholder="your email"
          class="input" />
        <input
          type="tel"
          name="phone"
          id="phone"
          required
          value="<?= $_SESSION['temp_data']['phone'] ?? '' ?>"
          placeholder="your phone"
          class="input" />
        <input
          type="password"
          name="password"
          id="password"
          minlength="6"
          required
          placeholder="password"
          class="input" />
        <input
          type="password"
          name="confirmPassword"
          id="confirmPassword"
          required
          placeholder="confirm password"
          class="input" />
        <?php if ($errorKey): ?>
          <div style="color: #a94442; font-weight: 800">
            <?= get_error_message($errorKey) ?>
          </div>
        <?php endif; ?>
        <button type="submit" class="btn">Зарегестрироваться</button>
      </form>
      <p class="register-form__text">Уже есть аккаунт? <a href="/index.php" class="link">Войти</a></p>
    </div>
  </div>


</body>

</html>