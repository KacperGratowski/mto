<?php
session_start();

// Check if the admin is logged in (you can add more robust authentication checks)
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Check if the 'id' parameter is present in the URL
if (isset($_GET['id'])) {
    $report_id = $_GET['id'];

    // Replace with your database connection code
    $servername = "localhost";
$username = "";
$password = "";
$dbname = "";


    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Update the status of the reported item to 'denied' in the database
    $sql = "UPDATE reported_items SET status = 'denied' WHERE id = $report_id";

    if ($conn->query($sql) === TRUE) {
        // Report denied successfully
        header("Location: dashboard.php");
        exit();
    } else {
        // Error in denying the report
        echo "Error: " . $conn->error;
    }

    $conn->close();
} else {
    // 'id' parameter not found in the URL
    echo "Invalid request.";
}
?>
