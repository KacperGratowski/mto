<?php
// Database connection
$servername = "localhost";
$username = "";
$password = "";
$dbname = "";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $discordUuid = $_POST["discord-uuid"];

    // Handle file upload (you may need to configure this part according to your server)
    $targetDirectory = "uploads/";

    // Generate a timestamp with milliseconds
    list($usec, $sec) = explode(" ", microtime());
    $milliseconds = round($usec * 1000);
    $timestamp = date("Y-m-d-H-i-s") . "-" . $milliseconds;

    $uploadedFileName = $_FILES["image"]["name"];
    $fileExtension = pathinfo($uploadedFileName, PATHINFO_EXTENSION);
    $targetFile = $targetDirectory . $timestamp . "." . $fileExtension;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        // Insert data into the database
        $sql = "INSERT INTO reported_items (image_path, discord_uuid) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $targetFile, $discordUuid);

        if ($stmt->execute()) {
            header("Location: https://miraculous.to");
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error uploading the file.";
    }
}

// Close the database connection
$conn->close();
?>

