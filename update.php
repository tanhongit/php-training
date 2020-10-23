<?php
session_start();

$link_edit = $_GET['update'];
$encode_link = $_SESSION['links_edit'][$link_edit];