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
   GET EMPLOYEE ID
========================= */

if (!isset($_GET['id'])) {
    header("Location: view_employees.php");
    exit();
}

$id = intval($_GET['id']);


/* =========================
   GET EMPLOYEE DETAILS
========================= */

$sql = "SELECT * FROM employees WHERE id = $id";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Database Error: " . mysqli_error($conn));
}

if (mysqli_num_rows($result) == 0) {
    die("Employee Not Found");
}

$employee = mysqli_fetch_assoc($result);


/* =========================
   UPDATE EMPLOYEE
========================= */

if (isset($_POST['update_employee'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);
    $salary = mysqli_real_escape_string($conn, $_POST['salary']);

    $update_sql = "UPDATE employees SET
                    name = '$name',
                    email = '$email',
                    phone = '$phone',
                    department = '$department',
                    salary = '$salary'
                   WHERE id = $id";

    if (mysqli_query($conn, $update_sql)) {

        header("Location: view_employees.php");
        exit();

    } else {

        die("Update Error: " . mysqli_error($conn));
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Employee</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="dashboard">

    <!-- HEADER -->

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


    <!-- EDIT EMPLOYEE -->

    <div class="section">

        <h2>Edit Employee</h2>

        <form method="POST" class="employee-form">

            <input
                type="text"
                name="name"
                value="<?php echo htmlspecialchars($employee['name']); ?>"
                placeholder="Employee Name"
                required
            >

            <input
                type="email"
                name="email"
                value="<?php echo htmlspecialchars($employee['email']); ?>"
                placeholder="Email"
                required
            >

            <input
                type="text"
                name="phone"
                value="<?php echo htmlspecialchars($employee['phone']); ?>"
                placeholder="Phone"
                required
            >

            <input
                type="text"
                name="department"
                value="<?php echo htmlspecialchars($employee['department']); ?>"
                placeholder="Department"
                required
            >

            <input
                type="number"
                name="salary"
                value="<?php echo $employee['salary']; ?>"
                placeholder="Salary"
                min="0"
                required
            >

            <button
                type="submit"
                name="update_employee"
            >
                Update Employee
            </button>

        </form>

    </div>

</div>

</body>

</html>