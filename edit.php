<?php
session_start();

if (isset($_GET['edit'])) {
    $link_edit = $_GET['edit'];
    $encode_link = $_SESSION['links_edit'][$link_edit];
} else header('location: home.php');

$user_id = intval($encode_link);

if ($_SESSION['user']['id'] != $user_id && $_SESSION['user']['user_type'] != 'admin') {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}

include('functions.php');

$result = [];
$userName = "";
$fullName = "";
$userEmail = "";
if (isset($_GET['edit'])) {
    if (isLoggedIn()) {
        $query = "SELECT * FROM users WHERE id=" . $user_id;
        $result = mysqli_query($conn, $query);
        $data = mysqli_fetch_assoc($result);
    }
}
?>

<html>

<head>
    <title>Edit User</title>
    <link rel="stylesheet" href="public/css/styles.css">
</head>

<body>
    <div class="header">
        <h2>Edit User</h2>
    </div>
    </form>

    <form method="post" action="update.php?update=<?= $link_edit ?>">
        <?php echo display_error(); ?>

        <div class="input-group">
            <label>Username</label>
            <input required type="text" name="username1" value="<?php echo $data['username']; ?>" placeholder="<?php echo $data['username']; ?>">
        </div>
        <div class="input-group">
            <label>Full Name</label>
            <input required type="text" name="fullname1" value="<?php echo $data['fullname']; ?>" placeholder="<?php echo $data['fullname']; ?>">
        </div>
        <div class="input-group">
            <label>Email</label>
            <input required type="email" name="email1" value="<?php echo $data['email']; ?>" placeholder="<?php echo $data['email']; ?>">
        </div>
        <div class="input-group">
            <button type="submit" class="btn" name="save_btn">Save</button>
        </div>
    </form>
    <div class="back" style="text-align: center; padding-top: 10px;">
        <button type="button" class="btn btn-info" onClick="javascript:history.go(-1)">Back</button> <a type="button" class="btn btn-info" href="change-password/index.php?code=<?= $link_edit ?>">Change Password</a>
    </div>

</body>

</html>