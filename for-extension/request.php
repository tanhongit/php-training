<?php
session_start();
include('../functions.php');
if (isset($_GET['mssv'])) {
    $presence = array(
        'id' => 0,
        'presence_mssv' => escape($_GET['mssv']),
        'presence_time' => gmdate('Y-m-d H:i:s', time() + 7 * 3600)
    );
    save('presence', $presence);
}
