<?php
session_start();
include('functions.php');

$user_id = intval($_GET['user_id']);
if ($_SESSION['user']['user_type'] == "admin") {
    if ($_SESSION['user']['id'] != $user_id) {
        user_delete($user_id);
    }
}

header('location:list.php');
