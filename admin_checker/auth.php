<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate user inputs (add more validation as needed)
    if (empty($username) || empty($password)) {
        header("Location: login.php?error=empty");
        exit();
    }

    // Database connection (replace with your actual database connection code)
    $servername = "localhost";
$username = "";
$password = "";
$dbname = "";

    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT id, username FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Login successful, set the admin's session ID and username
        $row = $result->fetch_assoc();
        $_SESSION['admin_id'] = $row['id'];

        header("Location: dashboard.php");
        exit();
    } else {
        // Login failed, redirect back to login page with an error message
        header("Location: https://http.cat/401");
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    // If the user accesses this script without submitting the form, redirect to login page
    header("Location: login.php");
    exit();
}
?>
