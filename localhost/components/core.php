<?php 
    session_start();
    $mysqli = new mysqli('localhost', 'root', '', 'lexadvice');

    $mysqli->set_charset("utf8mb4")
?>