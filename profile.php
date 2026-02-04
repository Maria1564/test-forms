<?php
session_start();

require_once 'src/db.php';
require_once 'src/helpers/index.php';

$idUser = $_SESSION["user_id"] ?? null;

if (!$idUser) {
    redirect("./index.php");
}

$stmt = db_query($conn, "SELECT * FROM users WHERE id = ?", "i", $idUser);
$user = $stmt->get_result()->fetch_assoc();

$errorKey = $_GET['error'] ?? null;


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="profile__wrapper">
        <div class="profile__header">
            <div class="profile__info">
                <h4 class="profile__title">Профиль</h4>
                <span class="profile__email"><?= $user["email"]; ?></span>
            </div>

            <form action="src/actions/logout.php" method="post">
                <button type="submit" class="btn">Выйти</button>
            </form>
        </div>
        <form action="./src/actions/update_user.php" method="post" class="form">
            <label class="profile__label">
                Имя:
                <input type="text" name="username" value="<?= $user["username"] ?>" class="profile__inp">
            </label>
            <label class="profile__label">
                Почта:
                <input type="email" name="email" value="<?= $user["email"] ?>" class="profile__inp">
            </label>
            <label class="profile__label">
                Номер телефона:
                <input type="text" name="phone" value="<?= $user["phone"] ?>" class="profile__inp">
            </label>
            <label class="profile__label">
                Текущий пароль:
                <input type="password" name="currentPassword" class="profile__inp">
            </label>
            <label class="profile__label">
                Новый пароль:
                <input type="password" name="newPassword" class="profile__inp">
            </label>
            <?php if ($errorKey): ?>
                <div style="color: #a94442; font-weight: 800">
                    <?= get_error_message($errorKey) ?>
                </div>
            <?php endif; ?>
            <button type="submit" class="btn">Сохранить</button>

        </form>


    </div>

</body>

</html>