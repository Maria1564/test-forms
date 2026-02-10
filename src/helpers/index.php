<?php
function db_query($conn, $sql, $types = "", ...$params)
{
    $stmt = $conn->prepare($sql);

    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();

    return $stmt;
}

function set_session($key, $value)
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION[$key] = $value;
}


function login_user($userId)
{
    set_session("user_id", $userId);
    unset($_SESSION["temp_data"]);
    redirect("../../profile.php");
}


function get_error_message($code)
{
    $messages = [
        'empty_fields'      => 'Все поля обязательны для заполнения!',
        'password_mismatch' => 'Пароли не совпадают!',
        'db_error'          => 'Ошибка сервера(( Попробуйте позже.',
        'user_exists'       => 'Пользователь с такими данными уже есть!',
        'not_found_user'    => 'Нет пользователя с такими данными',
        'wrong_password'    => 'Неверный пароль!',
        'password_too_short' => 'Новый пароль слишком короткий!',
        "undefined_captcha" => "Капча тоже обязательна",
        "invalid_captcha"   => "Вы похожи на робота, подозрительно"
    ];

    return $messages[$code] ?? 'Произошла неизвестная ошибка';
}

function redirect($path)
{
    header("Location: $path");
    exit();
}
