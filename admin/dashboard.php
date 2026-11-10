<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hospital_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" href="admin_styles.css">
</head>
<body>

<div class="hero_area">
    <!-- Header Section -->
    <header class="header_section">
        <div class="header_top">
            <div class="container">
                <div class="contact_nav">
                    <span>Admin Dashboard</span>
                    <a href="logout.php" class="btn btn-danger ml-auto">Logout</a>
                </div>
            </div>
        </div>
        <div class="header_bottom">
            <div class="container-fluid">
                <nav class="navbar navbar-expand-lg custom_nav-container">
                    <a class="navbar-brand" href="#">
                        <img src="../images/logo.png" alt="logo">
                    </a>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav">
                            <li class="nav-item active">
                                <a class="nav-link" href="dashboard.php">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="manage_appointments.php">Manage Appointments</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="manage_contacts.php">Manage Contacts</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container mt-5">
        <h2>Welcome to the Admin Dashboard</h2>

        <div class="row">
            <div class="col-md-6">
                <h3>Recent Appointments</h3>
                <table class="table table-bordered">
                    <tr>
                        <th>ID</th>
                        <th>Patient Name</th>
                        <th>Doctor</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                    <?php
                    $sql = "SELECT * FROM appointments ORDER BY created_at DESC LIMIT 5";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['patient_name']}</td>
                            <td>{$row['doctor_name']}</td>
                            <td>{$row['appointment_date']}</td>
                            <td><a href='delete_appointment.php?id={$row['id']}' class='btn btn-danger'>Delete</a></td>
                        </tr>";
                    }
                    ?>
                </table>
            </div>

            <div class="col-md-6">
                <h3>Recent Contact Messages</h3>
                <table class="table table-bordered">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Actions</th>
                    </tr>
                    <?php
                    $sql = "SELECT * FROM contacts ORDER BY created_at DESC LIMIT 5";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['full_name']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['message']}</td>
                            <td><a href='delete_contact.php?id={$row['id']}' class='btn btn-danger'>Delete</a></td>
                        </tr>";
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Footer Section -->
<footer class="footer_section">
    <div class="container">
        <p>&copy; <span id="displayYear"></span> All Rights Reserved By Your Hospital Name</p>
    </div>
</footer>

<!-- Scripts -->
<script src="../js/jquery-3.4.1.min.js"></script>
<script src="../js/bootstrap.js"></script>
<script src="../js/custom.js"></script>
</body>
</html>

<?php $conn->close(); ?>
