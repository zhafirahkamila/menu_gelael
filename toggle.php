<?php
include 'database.php'; 

if (isset($_POST['id']) && isset($_POST['status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];

    $query = "UPDATE product SET status = '$status' WHERE id = '$id'";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        echo 'success';
    } else {
        echo 'error';
    }
}
?>
