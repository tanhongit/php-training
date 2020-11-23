<?php
session_start();

include('../functions.php');

if (!isLoggedIn()) {
    $_SESSION['msg'] = "You must log in first";
    header('location: ../login.php');
}

if (!isAdmin()) {
    $_SESSION['msg'] = "You have no authority to perform this action";
    header('location: ../index.php');
}

$users_option = array(
    'order_by' => 'id asc'
);
$users = get_by_options('users', $users_option);
?>

<html>

<head>
    <title>List User Presence</title>

    <link rel="stylesheet" href="../public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../public/css/font-awesome.min.css">
    <link rel="stylesheet" href="../public/css/styles.css">
</head>

<body>
    <div class="container">
        <!-- notification message -->
        <?php if (isset($_SESSION['success'])) : ?>
            <div class="error success">
                <h3>
                    <?php
                    echo $_SESSION['success'];
                    unset($_SESSION['success']);
                    ?>
                </h3>
            </div>
        <?php endif ?>
        <div class="header">
            <h2>List User</h2>
        </div>
        <br>
        <form>
            <?php echo display_error(); ?>

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Username</th>
                        <th scope="col">Full name</th>
                        <th scope="col">Số tiết vắng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($users as $result) : ?>
                        <tr scope="row">
                            <td><?php echo $result['id']; ?></td>
                            <td><?php echo $result['username']; ?></td>
                            <td><?php echo $result['fullname']; ?></td>
                            <?php if ($result['presence'] > 0) : ?>
                                <td>
                                    <input type="text" id="inputnumber" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" value="">
                                </td>
                            <?php else : ?>
                                <td>
                                    <input type="text" id="inputnumber" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" value="5">
                                </td>
                        </tr>
                <?php endif;
                        endforeach; ?>
                </tbody>
            </table>
        </form>
    </div>
</body>

</html>