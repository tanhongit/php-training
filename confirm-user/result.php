<?php
session_start();
include '../functions.php';

if (!isset($_GET['code']) || empty($_GET['code'])) {
    echo "<div style='padding-top: 200' class='container'><div style='text-align: center;' class='alert alert-success'><strong>Error!</strong> Liên kết đã quá hạn!! <a href='../index.php'>Đăng nhập</a></div></div>";
}


if (isset($_SESSION['verificationLink']) && $_SESSION['activeCode'] == $_GET['code']) {
    echo ($_GET['code']);
    $select_user_option = array(
        'order_by' => 'id'
    );
    $user_need_activate = get_by_options('users', $select_user_option);

    foreach ($user_need_activate as $user) {
        if ($user['verificationCode'] == $_GET['code']) {
            $verifi_id_user = $user['id'];
        }
    }

    if (!isset($verifi_id_user)) {
        exit;
    }


    $user_edit = array(
        'id' => $verifi_id_user,
        'status' => 1
    );
    save('users', $user_edit);
    echo "<div style='padding-top: 200' class='container'><div style='text-align: center;' class='alert alert-success'><strong>Done!</strong> Bạn đã kích hoạt tài khoản thành công, giờ bạn đã có thể đăng nhập vào website Hãy đến <a href='../login.php'>Đăng nhập</a></div></div>";
}
