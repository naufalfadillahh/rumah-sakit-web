<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
</head>
<body>
    <div class="container">
        <h2>Admin Dashboard</h2>
        <a href="logout.php" class="btn btn-danger">Logout</a>

        <h3>Manage Appointments</h3>
        <table class="table">
            <tr>
                <th>ID</th>
                <th>Patient Name</th>
                <th>Doctor</th>
                <th>Department</th>
                <th>Phone</th>
                <th>Symptoms</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
            <?php
            $sql = "SELECT * FROM appointments";
            $result = $conn->query($sql);

            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['patient_name']}</td>
                    <td>{$row['doctor_name']}</td>
                    <td>{$row['department_name']}</td>
                    <td>{$row['phone_number']}</td>
                    <td>{$row['symptoms']}</td>
                    <td>{$row['appointment_date']}</td>
                    <td>
                        <a href='delete_appointment.php?id={$row['id']}' class='btn btn-danger'>Delete</a>
                    </td>
                </tr>";
            }
            ?>
        </table>

        <h3>Contact Messages</h3>
        <table class="table">
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Message</th>
                <th>Actions</th>
            </tr>
            <?php
            $sql = "SELECT * FROM contacts";
            $result = $conn->query($sql);

            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['full_name']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['phone_number']}</td>
                    <td>{$row['message']}</td>
                    <td>
                        <a href='delete_contact.php?id={$row['id']}' class='btn btn-danger'>Delete</a>
                    </td>
                </tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>
