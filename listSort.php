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

$query2 = "SELECT * FROM users ORDER BY id ASC";
$result2 = mysqli_query($conn, $query2);

$_SESSION['results_user_sort'] = $result2;
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
                        foreach ($_SESSION['results_user_sort'] as $result) : ?>
                            <tr scope="row">
                                <td><?php echo $result['id']; ?></td>
                                <td><?php echo $result['username']; ?></td>
                                <td><?php echo $result['fullname']; ?></td>
                                <td><?php echo $result['email']; ?></td>
                                <td>
                                    <a href="userinfo.php?user_id=<?= getLink($result['id']) ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                    <a href="edit.php?edit=<?= getLink($result['id']) ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                    <a onclick="return confirm('Are you sure to delete?')" href="delete.php?user_id=<?= getLink($result['id']) ?>"><i class="fa fa-times" aria-hidden="true"></i></a>

                                </td>
                            </tr>
                        <?php
                        endforeach;
                        ?>

                    </tbody>
                </table>
            </div>
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