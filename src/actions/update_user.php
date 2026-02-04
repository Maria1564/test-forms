<?php
session_start();

require_once '../db.php';
require_once "../helpers/index.php";

$idUser = $_SESSION["user_id"] ?? null;

if (!$idUser) {
    redirect("../../index.php");
};

$stmt = db_query($conn, "SELECT * FROM users WHERE id = ?", "i", $idUser);
$user = $stmt->get_result()->fetch_assoc();


$newUsername = trim($_POST["username"]);
$newEmail = trim($_POST["email"]);
$newPhone = trim($_POST["phone"]);
$currPass = $_POST["currentPassword"];
$newPass = $_POST["newPassword"];


if (empty($newUsername) || empty($newEmail) || empty($newPhone)) {
    redirect("../../profile.php?error=empty_fields");
}

if (!password_verify($currPass, $user["password"])) {
    redirect("../../profile.php?error=wrong_password");
}

if (!empty($newPass) &&  strlen($newPass) < 6) {
    redirect("../../profile.php?error=password_too_short");
}

if ($newUsername === $user["username"] && $newEmail === $user["email"] && $newPhone === $user["phone"] && empty($newPass)) {
    redirect("../../profile.php");
}

$sqlQuery = "UPDATE users SET username = ?, email = ?, phone = ?";
$types = "sss";
$params = [$newUsername, $newEmail, $newPhone];

if (!empty($newPass)) {
    $hashedPass = password_hash($newPass, PASSWORD_DEFAULT);
    $sqlQuery = $sqlQuery . ", password = ?";
    $types = $types . "s";
    $params[] = $hashedPass;
}

$sqlQuery = $sqlQuery . " WHERE id = ?";
$types = $types . "i";
$params[] = $idUser;

try {
    $stmt = db_query($conn, $sqlQuery, $types, ...$params);
    redirect("../../profile.php");
} catch (mysqli_sql_exception $e) {
    if ($e->getCode() === 1062) {
        redirect("../../profile.php?error=user_exists");
    } else {
        redirect("../../profile.php?error=db_error");
    }
}
