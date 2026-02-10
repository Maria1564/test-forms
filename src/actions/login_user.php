<?php
session_start();

require_once '../db.php';
require_once "../helpers/index.php";

$emailOrPhone = $_POST["login"];
$password = $_POST["password"];
$captcha = $_POST["g-recaptcha-response"];

set_session("temp_data", [
    "login" => $emailOrPhone,
]);

if (empty($captcha)) {
    redirect("../../index.php?error=undefined_captcha");
}

if (empty($emailOrPhone) || empty($password)) {
    redirect("../../index.php?error=empty_fields");
};

$secretKey = "6LfcxGYsAAAAANCQafjdAmi4eEORMDcUQ1r77uo0";

$responseCaptcha = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$captcha}");
$result = json_decode($responseCaptcha, true);

if (!$result["success"]) {
    redirect("../../index.php?error=invalid_captcha");
}

$column = str_contains($emailOrPhone, '@') ? 'email' : 'phone';

$sqlQuery = "SELECT * FROM users WHERE $column = ?";
$stmt = db_query($conn, $sqlQuery, "s", $emailOrPhone);

$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    redirect("../../index.php?error=not_found_user");
}

$isVerify = password_verify($password, $user["password"]);

if (!$isVerify) {
    redirect("../../index.php?error=wrong_password");
}

login_user($user["id"]);
