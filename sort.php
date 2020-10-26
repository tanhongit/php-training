<?php
$conn = mysqli_connect("localhost", "root", "", "userlogin");
$output = '';
$order = $_POST["order"];
if ($order == 'asc') {
    $order = 'desc';
} else {
    $order = 'asc';
}
$query = "SELECT * FROM users ORDER BY " . $_POST["column_name"] . " " . $_POST["order"] . "";
$result = mysqli_query($conn, $query);
$output .= '  
 <table class="table">  
    <thead>
      <tr>  
           <th scope="col"><a class="column_sort" id="id" data-order="' . $order . '">ID</a></th>
           <th scope="col"><a class="column_sort" id="username" data-order="' . $order . '">Username</a></th>
           <th scope="col"><a class="column_sort" id="fullname" data-order="' . $order . '">Full Name</a></th>
           <th scope="col"><a class="column_sort" id="email" data-order="' . $order . '">Email</a></th>
           <th scope="col">Action</th>
      </tr>  
    <thead>
 ';
while ($row = mysqli_fetch_array($result)) {
    $output .= '  
      <tr>  
           <td>' . $row["id"] . '</td>  
           <td>' . $row["username"] . '</td>  
           <td>' . $row["fullname"] . '</td>  
           <td>' . $row["email"] . '</td>  
           <td>
                                        <a href="userinfo.php?user_id=<?= getLink($rowSort['id']) ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                        <a href="edit.php?edit=<?= getLink($rowSort['id']) ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                        <a onclick="return confirm('Are you sure to delete?')" href="delete.php?user_id=<?= getLink($rowSort['id']) ?>"><i class="fa fa-times" aria-hidden="true"></i></a>
                                    </td>
      </tr> 

      ';
}
$output .= '</table>';
echo $output;
