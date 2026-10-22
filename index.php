<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

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
   DASHBOARD DATA
========================= */

$result = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total FROM employees"
);

if (!$result) {
    die("Database Error: " . mysqli_error($conn));
}

$total_employee = mysqli_fetch_assoc($result)['total'];


$result = mysqli_query(
    $conn,
    "SELECT COALESCE(SUM(salary), 0) AS total FROM employees"
);

if (!$result) {
    die("Database Error: " . mysqli_error($conn));
}

$total_salary = mysqli_fetch_assoc($result)['total'];


$result = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM employees
     WHERE salary >= 30000"
);

if (!$result) {
    die("Database Error: " . mysqli_error($conn));
}

$salary30 = mysqli_fetch_assoc($result)['total'];


$result = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM employees
     WHERE salary >= 40000"
);

if (!$result) {
    die("Database Error: " . mysqli_error($conn));
}

$salary40 = mysqli_fetch_assoc($result)['total'];


$result = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM employees
     WHERE salary >= 50000"
);

if (!$result) {
    die("Database Error: " . mysqli_error($conn));
}

$salary50 = mysqli_fetch_assoc($result)['total'];

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard - Employee Management System</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="dashboard">


    <!-- =========================
         HEADER
    ========================= -->

    <div class="header">

        <div>

            <h1>Employee Management System</h1>

            <p>
                Welcome,
                <?php echo htmlspecialchars($_SESSION['username']); ?>
            </p>

        </div>

        <a href="logout.php" class="logout-btn">
            Logout
        </a>

    </div>


    <!-- =========================
         DASHBOARD TITLE
    ========================= -->

    <h2 class="dashboard-title">
        Dashboard
    </h2>


    <!-- =========================
         DASHBOARD CARDS
    ========================= -->

    <div class="cards">


        <!-- TOTAL EMPLOYEES -->

        <div class="card">

            <h3>Total Employees</h3>

            <p>
                <?php echo $total_employee; ?>
            </p>

        </div>


        <!-- TOTAL SALARY -->

        <div class="card">

            <h3>Total Salary</h3>

            <p>
                ₹<?php echo number_format($total_salary, 2); ?>
            </p>

        </div>


        <!-- 30000+ -->

        <a
            href="search_employee.php?search=30000"
            class="card"
        >

            <h3>Salary ₹30,000+</h3>

            <p>
                <?php echo $salary30; ?>
            </p>

        </a>


        <!-- 40000+ -->

        <a
            href="search_employee.php?search=40000"
            class="card"
        >

            <h3>Salary ₹40,000+</h3>

            <p>
                <?php echo $salary40; ?>
            </p>

        </a>


        <!-- 50000+ -->

        <a
            href="search_employee.php?search=50000"
            class="card"
        >

            <h3>Salary ₹50,000+</h3>

            <p>
                <?php echo $salary50; ?>
            </p>

        </a>


    </div>


    <!-- =========================
         MENU BUTTONS
    ========================= -->

    <div class="menu">

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


</div>

</body>

</html>