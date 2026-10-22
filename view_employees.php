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
   DELETE EMPLOYEE
========================= */

if (isset($_GET['delete'])) {

    $id = intval($_GET['delete']);

    $delete_sql = "DELETE FROM employees WHERE id = $id";

    if (mysqli_query($conn, $delete_sql)) {

        header("Location: view_employees.php");
        exit();

    } else {

        die("Delete Error: " . mysqli_error($conn));
    }
}


/* =========================
   GET EMPLOYEES
========================= */

$sql = "SELECT * FROM employees ORDER BY id DESC";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Database Error: " . mysqli_error($conn));
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>View Employees</title>

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
         MENU
    ========================= -->

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


    <!-- =========================
         EMPLOYEE TABLE
    ========================= -->

    <div class="section">

        <h2>View Employees</h2>

        <div class="table-container">

            <table>

                <tr>

                    <th>ID</th>

                    <th>Name</th>

                    <th>Email</th>

                    <th>Phone</th>

                    <th>Department</th>

                    <th>Salary</th>

                    <th>Action</th>

                </tr>


                <?php

                if (mysqli_num_rows($result) > 0) {

                    while ($row = mysqli_fetch_assoc($result)) {

                ?>

                <tr>

                    <td>
                        <?php echo $row['id']; ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['name']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['email']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['phone']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['department']); ?>
                    </td>

                    <td>
                        ₹<?php echo number_format($row['salary'], 2); ?>
                    </td>

                    <td>

                        <a
                            href="edit_employee.php?id=<?php echo $row['id']; ?>"
                            class="edit-btn"
                        >
                            Edit
                        </a>

                        <a
                            href="view_employees.php?delete=<?php echo $row['id']; ?>"
                            class="delete-btn"
                            onclick="return confirm('Are you sure you want to delete this employee?');"
                        >
                            Delete
                        </a>

                    </td>

                </tr>

                <?php

                    }

                } else {

                ?>

                <tr>

                    <td colspan="7">
                        No Employees Found
                    </td>

                </tr>

                <?php

                }

                ?>

            </table>

        </div>

    </div>


</div>

</body>

</html>