<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include "db.php";

/* LOGIN CHECK */
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$search = "";

if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
}


/* =========================
   SEARCH / SALARY FILTER
========================= */

if ($search != "") {

    $safe_search = mysqli_real_escape_string($conn, $search);

    /*
     * Salary filter only when the value
     * comes from salary buttons
     */

    if (isset($_GET['salary_filter'])) {

        $salary = intval($search);

        $sql = "
            SELECT *
            FROM employees
            WHERE salary >= $salary
            ORDER BY salary DESC
        ";

    } else {

        /*
         * Normal search
         * Name / Email / Phone / Department
         */

        $sql = "
            SELECT *
            FROM employees
            WHERE
                name LIKE '%$safe_search%'
                OR email LIKE '%$safe_search%'
                OR phone LIKE '%$safe_search%'
                OR department LIKE '%$safe_search%'
            ORDER BY id DESC
        ";
    }

} else {

    $sql = "
        SELECT *
        FROM employees
        ORDER BY id DESC
    ";
}


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

    <title>Search Employee</title>

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


    <!-- SEARCH SECTION -->

    <div class="section">

        <h2>Search Employee</h2>

        <form method="GET" class="search-form">

            <input
                type="text"
                name="search"
                placeholder="Name / Email / Phone / Department"
                value="<?php echo htmlspecialchars($search); ?>"
            >

            <button type="submit">
                Search
            </button>

            <a href="search_employee.php">
                Clear
            </a>

        </form>


        <!-- SALARY FILTERS -->

        <div class="salary-buttons">

            <a href="search_employee.php?search=30000&salary_filter=1">
                ₹30,000+
            </a>

            <a href="search_employee.php?search=40000&salary_filter=1">
                ₹40,000+
            </a>

            <a href="search_employee.php?search=50000&salary_filter=1">
                ₹50,000+
            </a>

        </div>

    </div>


    <!-- RESULTS -->

    <div class="section">

        <h2>Employee Results</h2>

        <div class="table-container">

            <table>

                <tr>

                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Department</th>
                    <th>Salary</th>

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

                </tr>

                <?php

                    }

                } else {

                ?>

                <tr>

                    <td colspan="6">
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