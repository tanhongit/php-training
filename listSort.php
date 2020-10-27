<?php
session_start();

include('functions.php');

if (!isLoggedIn()) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}

if (!isAdmin()) {
    $_SESSION['msg'] = "You have no authority to perform this action";
    header('location: index.php');
}

$results = [];

if (isset($_GET['page'])) $page = intval($_GET['page']);
else $page = 1;

$page = ($page > 0) ? $page : 1;
$limit = 5;
$offset = ($page - 1) * $limit;
$url = 'list.php?list=6';

$option_id_desc = array(
    'order_by' => 'id DESC',
    'limit' => $limit,
    'offset' => $offset,
);
$option_id_asc = array(
    'order_by' => 'id ASC',
    'limit' => $limit,
    'offset' => $offset,
);


// Gán hàm addslashes để chống sql injection
isset($_GET['search']) ? $search = addslashes($_GET['search']) : $search = "";
$options_search = array(
    'where' => "username LIKE '%" . ($search) . "%' or fullname like '%" . ($search) . "%'",
    'limit' => $limit,
    'offset' => $offset,
    'order_by' => 'id ASC'
);
$query = "SELECT * FROM users WHERE username LIKE '%$search%' OR fullname LIKE '%$search%' OR email LIKE  '%$search%'";
global $conn;
$sql = mysqli_query($conn, $query);
$num = mysqli_num_rows($sql);

//sortby 
$path = explode('=', $_SERVER['REQUEST_URI']);
$id_list = $path[count($path) - 1];
if (isset($_POST['list'])) {
    $id_list = $_POST['list'];
}
if (isAdmin()) {
    $id_list == 5 ? $_SESSION['results_user'] = get_by_options('users', $option_id_desc)
        : $_SESSION['results_user'] = get_by_options('users', $option_id_asc);
}

//pagination
if ($search != "") {
    $total_rows = get_total('users', $options_search);
} else {
    $id_list == 5 ? $total_rows = get_total('users', $option_id_asc)
        : $total_rows = get_total('users', $option_id_desc);
}
$total = ceil($total_rows / $limit);
$pagination = pagination_admin($url, $page, $total);







$querySort = "SELECT * FROM users ORDER BY id ASC";
$resultSort = mysqli_query($conn, $querySort);
?>

<html>

<head>
    <title>Register</title>

    <link rel="stylesheet" href="public/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/css/font-awesome.min.css">
    <link rel="stylesheet" href="public/css/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
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
        <div class="row">
            <div class="col-md-12">
                <form action="list.php" method="get">
                    <div class="input-group">
                        <label>Search:</label>
                        <input type="text" name="search" />
                    </div>
                    <button type="submit" name="ok" value="<?php isset($_GET['search']) ? $_GET['search'] : "search" ?>" class="btn btn-info">Search</button>
                </form>
            </div>
        </div>
        <br>
        <form>
            <?php echo display_error(); ?>
            <div class="table-responsive" id="users">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col"><a class="column_sort" id="id" data-order="asc">ID</a></th>
                            <th scope="col"><a class="column_sort" id="username" data-order="asc">Username</a></th>
                            <th scope="col"><a class="column_sort" id="fullname" data-order="asc">Full Name</a></th>
                            <th scope="col"><a class="column_sort" id="email" data-order="asc">Email</a></th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($_REQUEST['ok'])) {
                            if ($search == "") {
                                header("location: list.php");
                            } elseif ($num > 0) {
                                echo "$num kết quả trả về với từ khóa '<b>$search</b>'";
                                while ($rowSort = mysqli_fetch_assoc($resultSort)) { ?>
                                    <tr scope="row">
                                        <td><?php echo $rowSort['id']; ?></td>
                                        <td><?php echo $rowSort['username']; ?></td>
                                        <td><?php echo $rowSort['fullname']; ?></td>
                                        <td><?php echo $rowSort['email']; ?></td>
                                        <td>
                                            <a href="userinfo.php?user_id=<?= getLink($rowSort['id']) ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                            <a href="edit.php?edit=<?= getLink($rowSort['id']) ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                            <a onclick="return confirm('Are you sure to delete?')" href="delete.php?user_id=<?= getLink($rowSort['id']) ?>"><i class="fa fa-times" aria-hidden="true"></i></a>
                                        </td>
                                    </tr>
                            <?php  }
                            } else {
                                echo "Khong tim thay ket qua!";
                            }
                            ?>

                            <?php } else {

                            while ($rowSort = mysqli_fetch_array($resultSort)) {
                            ?>
                                <tr scope="row">
                                    <td><?php echo $rowSort['id']; ?></td>
                                    <td><?php echo $rowSort['username']; ?></td>
                                    <td><?php echo $rowSort['fullname']; ?></td>
                                    <td><?php echo $rowSort['email']; ?></td>
                                    <td>
                                        <a href="userinfo.php?user_id=<?= getLink($rowSort['id']) ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                        <a href="edit.php?edit=<?= getLink($rowSort['id']) ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                        <a onclick="return confirm('Are you sure to delete?')" href="delete.php?user_id=<?= getLink($rowSort['id']) ?>"><i class="fa fa-times" aria-hidden="true"></i></a>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        <?php

                        }
                        ?>

                    </tbody>
                </table>
            </div>
            <?php if ($search == "") : ?>
                <div class="row">
                    <div class="col-md-12">
                        <?php echo $pagination; ?>
                    </div>
                </div>
            <?php endif; ?>
        </form>
        <div class="back" style="text-align: center; padding-top: 10px;">
            <button type="button" class="btn btn-info" onClick="javascript:history.go(-1)">Back</button>
        </div>
    </div>
</body>
<script>
    $(document).ready(function() {
        $(document).on('click', '.column_sort', function() {
            var column_name = $(this).attr("id");
            var order = $(this).data("order");
            var arrow = '';
            //glyphicon glyphicon-arrow-up  
            //glyphicon glyphicon-arrow-down  
            if (order == 'desc') {
                arrow = '&nbsp;<span class="glyphicon glyphicon-arrow-down"></span>';
            } else {
                arrow = '&nbsp;<span class="glyphicon glyphicon-arrow-up"></span>';
            }
            $.ajax({
                url: "sort.php",
                method: "POST",
                data: {
                    column_name: column_name,
                    order: order
                },
                success: function(data) {
                    $('#users').html(data);
                    $('#' + column_name + '').append(arrow);
                }
            })
        });
    });
</script>

</html>