<?php

session_start();
include "db.php";

$message = "";

if (isset($_POST['login'])) {

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM users 
            WHERE username = '$username' 
            AND password = '$password'";

    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) == 1) {

        $_SESSION['username'] = $username;

        header("Location: index.php");
        exit();

    } else {

        $message = "Invalid Username or Password";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Login - Employee Management System</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="login-container">

    <h1>Employee Management System</h1>

    <h2>Login</h2>

    <?php if ($message != ""): ?>

        <p class="error">
            <?php echo $message; ?>
        </p>

    <?php endif; ?>

    <form method="POST">

        <input
            type="text"
            name="username"
            placeholder="Enter Username"
            required
        >

        <input
            type="password"
            name="password"
            placeholder="Enter Password"
            required
        >

        <button type="submit" name="login">
            Login
        </button>

    </form>

</div>

</body>
</html>