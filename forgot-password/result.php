<?php
session_start();

if (!isset($_POST['code'])) header('location: index.php');

if ($_SESSION['forgot_pass_Code'] == $_GET['code']) {
    header('location:../change-password/index.php?code=' . $_SESSION['forgot_pass_Code']);
} else {
}
