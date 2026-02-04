<?php

const SERVER_NAME = "127.0.1.28";
const USERNAME = "root";
const PASSWORD = "";
const DB_NAME = "some_db";

$conn = new mysqli(SERVER_NAME, USERNAME, PASSWORD, DB_NAME);

if($conn->connect_error) {
    die("Не удалось подключится к бд");
};
