<?php
session_start();
require_once '../db.php';
require_once "../helpers/index.php";

$username = trim($_POST["username"]);
$email = trim($_POST["email"]);
$phone = trim($_POST["phone"]);
$password = $_POST["password"];
$confirmPassword = $_POST["confirmPassword"];

set_session("temp_data", [
    'username' => $username,
    'email' => $email,
    'phone' => $phone,
]);

if (empty($username) || empty($email) || empty($phone) || empty($password)) {
    redirect("../../register.php?error=empty_fields");
} else if ($password !== $confirmPassword) {
    redirect("../../register.php?error=password_mismatch");
}

$hashedPass = password_hash($password, PASSWORD_DEFAULT);

$sqlQuery = "INSERT INTO users (username, phone, email, password) VALUES (?, ?, ?, ?)";

try {
    $stmt = db_query($conn, $sqlQuery, "ssss", $username, $phone, $email, $hashedPass);
    login_user($conn->insert_id);
} catch (mysqli_sql_exception $e) {
    if ($e->getCode() === 1062) {
        header("Location: ../../register.php?error=user_exists");
    } else {
        header("Location: ../../register.php?error=db_error");
    }
    exit();
}
