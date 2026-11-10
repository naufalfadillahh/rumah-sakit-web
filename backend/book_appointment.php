<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hospital_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $patient_name = $_POST['patient_name'];
    $doctor_name = $_POST['doctor_name'];
    $department_name = $_POST['department_name'];
    $phone_number = $_POST['phone_number'];
    $symptoms = $_POST['symptoms'];
    $appointment_date = $_POST['appointment_date'];

    $sql = "INSERT INTO appointments (patient_name, doctor_name, department_name, phone_number, symptoms, appointment_date)
            VALUES ('$patient_name', '$doctor_name', '$department_name', '$phone_number', '$symptoms', '$appointment_date')";

    if ($conn->query($sql) === TRUE) {
        echo "Appointment booked successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
