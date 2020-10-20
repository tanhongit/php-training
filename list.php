<?php
session_start();

include('functions.php');

$results = [];

$option_name_desc = array(
    'order_by' => 'username',
    'limit' => '12',
    'offset' => '0',
);
$option_name_asc = array(
    'order_by' => 'username',
    'limit' => '12',
    'offset' => '0',
);
$option_fullname_asc = array(
    'order_by' => 'createDate ASC',
    'limit' => '12',
    'offset' => '0',
);
$option_fullname_desc = array(
    'order_by' => 'fullname DESC',
    'limit' => '12',
    'offset' => '0',
);
$option_id_desc = array(
    'order_by' => 'id DESC',
    'limit' => '12',
    'offset' => '0',
);
$option_id_asc = array(
    'order_by' => 'id ASC',
    'limit' => '12',
    'offset' => '0',
);

$path = explode('=', $_SERVER['REQUEST_URI']);
$id_list = $path[count($path) - 1];
if (isset($_POST['list'])) {
    $id_list = $_POST['list'];
}
if (isAdmin()) {
    $id_list == 5 ? $results = get_by_options('users', $option_id_desc)
        : $results = get_by_options('users', $option_id_asc);
}
?>

<html>

<head>
    <title>Register</title>

    <link rel="stylesheet" href="public/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/css/font-awesome.min.css">
    <link rel="stylesheet" href="public/css/styles.css">
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>List User</h2>
        </div>
        <div class="row">
            <div class="col-md-6">
                <form action="" method="post">
                    <div class="input-group">
                        <label>Sort By:</label>
                        <select class="form-control" name="list" id="list">
                            <option name="list" value="5">ID DESC</option>
                            <option name="list" value="6">ID ASC</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Go</button>
                </form>
            </div>
            <div class="col-md-6">
                <form action="list.php" method="get">
                    <div class="input-group">
                        <label>Search:</label>
                        <input type="text" name="search" />
                    </div>
                    <button type="submit" name="ok" value="search" class="btn btn-info">Search</button>
                </form>
            </div>
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
                        <th scope="col">Email</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($_REQUEST['ok'])) {
                        // Gán hàm addslashes để chống sql injection
                        $search = addslashes($_GET['search']);
                        // if (empty($search)) {
                        //     echo "Yeu cau nhap du lieu vao o trong";
                        // } else {
                        $query = "SELECT * FROM users WHERE username LIKE '%$search%' OR fullname LIKE '%$search%' ";
                        global $conn;
                        $sql = mysqli_query($conn, $query);
                        $num = mysqli_num_rows($sql);
                        if ($search == "") {
                            header("location: list.php");
                        } elseif ($num > 0) {
                            echo "$num ket qua tra ve voi tu khoa '<b>$search</b>'";
                            while ($result = mysqli_fetch_assoc($sql)) { ?>
                                <tr scope="row">
                                    <td><?php echo $result['id']; ?></td>
                                    <td><?php echo $result['username']; ?></td>
                                    <td><?php echo $result['fullname']; ?></td>
                                    <td><?php echo $result['email']; ?></td>
                                    <td>
                                        <a><i class="fa fa-eye" aria-hidden="true"></i></a>
                                        <a href="edit.php?edit=<?= $result['id'] ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                        <a onclick="return confirm('Are you sure to delete?')" href="delete.php?user_id=<?= $result['id'] ?>"><i class="fa fa-times" aria-hidden="true"></i></a>

                                    </td>
                                </tr>
                        <?php  }
                        } else {
                            echo "Khong tim thay ket qua!";
                        }
                        // }
                        ?>

                        <?php } else {
                        foreach ($results as $result) : ?>
                            <tr scope="row">
                                <td><?php echo $result['id']; ?></td>
                                <td><?php echo $result['username']; ?></td>
                                <td><?php echo $result['fullname']; ?></td>
                                <td><?php echo $result['email']; ?></td>
                                <td>
                                    <a><i class="fa fa-eye" aria-hidden="true"></i></a>
                                    <a href="edit.php?edit=<?= $result['id'] ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                    <a onclick="return confirm('Are you sure to delete?')" href="delete.php?user_id=<?= $result['id'] ?>"><i class="fa fa-times" aria-hidden="true"></i></a>

                                </td>
                            </tr>
                    <?php endforeach;
                    } ?>

                </tbody>
            </table>

        </form>
        <div class="back" style="text-align: center">
            <button type="button" class="btn btn-info" onClick="javascript:history.go(-1)">Back</button>

        </div>
    </div>
</body>

</html>