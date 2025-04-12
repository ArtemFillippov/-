<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}


if (isset($require_admin) && $require_admin === true && $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit;
}
?> 