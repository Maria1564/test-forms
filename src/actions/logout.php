<?php
session_start();

require_once "../helpers/index.php";

$_SESSION = [];

session_destroy();

redirect("../../index.php");
