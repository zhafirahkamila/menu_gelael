<?php
session_start();
if (isset($_SESSION['id'])) {
    header('location:../dashboard.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link href="./custom.css" rel="stylesheet">
</head>

<body>
    <div>
        <div class="container con-login">
            <div class="card-login">
                <h3 style="margin-bottom: 10px;">Login</h3>
                <form action="" method="post">
                    <input type="email" name="email" placeholder="Email" id="Email" class="form-control" required>
                    <div style="position: relative;">
                        <input type="password" name="pass" placeholder="Password" id="Password" class="form-control" required>
                        <i class="fa-solid fa-eye-slash" aria-hidden="true" id="togglePass"
                            style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
                    </div>
                    <!-- <select class="form-control admin-role" name="roles" id="editRole">
                        <option value="" disabled selected>Choose Role</option>
                        <option value="Admin">Admin</option>
                        <option value="Superadmin">Superadmin</option>
                    </select> -->
                    <button type="submit" name="login" class="btn btn-primary btn-md"
                        style="width: 100%; cursor: pointer;">Login</button>
                </form>

                <?php

                //Check if submit button is clicked
                if (isset($_POST['login'])) {

                    include 'database.php';

                    //Check data login
                    $query_select = 'SELECT * from admin WHERE email = "' . $_POST['email'] . '" and password = "' . $_POST['pass'] . '"';
                    $run_sql_select = mysqli_query($conn, $query_select);
                    $d = mysqli_fetch_object($run_sql_select);

                    if ($d) {
                        //buat session
                        $_SESSION['id'] = $d->id;
                        $_SESSION['name'] = $d->name;
                        $_SESSION['roles'] = $d->roles;
                        $_SESSION['kodecabang'] = $d->kodecabang;
                        header('location: http://localhost/menu_gelael/dashboard.php');
                    } else {
                        echo 'Email or Password is wrong';
                    }
                }
                ?>

            </div>
        </div>
    </div>
</body>

<script>
    document.getElementById("togglePass").addEventListener("click", function () {
        const passwordField = document.getElementById("Password");
        const type = passwordField.getAttribute("type") === "password" ? "text" : "password";
        passwordField.setAttribute("type", type);

        this.classList.toggle("fa-eye-slash");
        this.classList.toggle("fa-eye");
    });

</script>


</html>