<?php
session_start();
include('finctions.php');
if (isset($_GET['mssv'])) {
    $presence = array(
        'presence_mssv' => escape($_GET['mssv']),
        'presence_time' => gmdate('Y-m-d H:i:s', time() + 7 * 3600)
    );
    save('presence', $presence);
}
