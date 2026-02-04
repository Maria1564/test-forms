<?php
session_start();

require_once '../db.php';
require_once "../helpers/index.php";

$emailOrPhone = $_POST["login"];
$password = $_POST["password"];


set_session("temp_data", [
    "login" => $emailOrPhone,
]);

if (empty($emailOrPhone) || empty($password)) {
    redirect("../../index.php?error=empty_fields");
};


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
