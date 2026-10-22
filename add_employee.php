<?php

session_start();
include "db.php";

/* =========================
   LOGIN CHECK
========================= */

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

/* =========================
   ADD EMPLOYEE
========================= */

$message = "";

if (isset($_POST['add_employee'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);
    $salary = mysqli_real_escape_string($conn, $_POST['salary']);

    $sql = "INSERT INTO employees
            (name, email, phone, department, salary)
            VALUES
            ('$name', '$email', '$phone', '$department', '$salary')";

    if (mysqli_query($conn, $sql)) {

        $message = "Employee Added Successfully!";

    } else {

        $message = "Error: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Employee</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="dashboard">

    <!-- HEADER -->

    <div class="header">

        <div>

            <h1>Employee Management System</h1>

            <p>
                Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>
            </p>

        </div>

        <a href="logout.php" class="logout-btn">
            Logout
        </a>

    </div>


    <!-- MENU -->

    <div class="menu">

        <a href="index.php">
            Dashboard
        </a>

        <a href="add_employee.php">
            Add Employee
        </a>

        <a href="view_employees.php">
            View Employees
        </a>

        <a href="search_employee.php">
            Search Employee
        </a>

    </div>


    <!-- ADD EMPLOYEE -->

    <div class="section">

        <h2>Add Employee</h2>

        <?php if ($message != ""): ?>

            <p style="color: green; margin-bottom: 15px;">
                <?php echo $message; ?>
            </p>

        <?php endif; ?>


        <form method="POST" class="employee-form">

            <input
                type="text"
                name="name"
                placeholder="Enter Employee Name"
                required
            >

            <input
                type="email"
                name="email"
                placeholder="Enter Email"
                required
            >

            <input
                type="text"
                name="phone"
                placeholder="Enter Phone Number"
                required
            >

            <input
                type="text"
                name="department"
                placeholder="Enter Department"
                required
            >

            <input
                type="number"
                name="salary"
                placeholder="Enter Salary"
                min="0"
                required
            >

            <button
                type="submit"
                name="add_employee"
            >
                Add Employee
            </button>

        </form>

    </div>

</div>

</body>

</html>