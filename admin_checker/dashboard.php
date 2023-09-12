<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="css/dash.css">
</head>
<body>
    <header>
        <h1>Admin Dashboard</h1>
        <a href="logout.php">Logout</a>
    </header>
    <main>
        <h2>Reported Items</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Discord UUID</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php
          session_start();
            // Replace with your database connection code
            $servername = "localhost";
            $dbusername = "mtotests";
            $dbpassword = "MTOtests";
            $dbname = "mtotests";

            $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
          if (!isset($_SESSION['admin_id'])) {
  			  header("Location: index.html");
  			  exit();
}

            // Fetch reported items from the database
            $sql = "SELECT id, image_path, discord_uuid, status FROM reported_items WHERE status = 'pending'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
					echo "<td><img src='../" . $row["image_path"] . "' width='100'></td>";
                    echo "<td>" . $row["discord_uuid"] . "</td>";
                    echo "<td>" . $row["status"] . "</td>";
                    echo "<td>";
                    echo "<a href='accept_report.php?id=" . $row["id"] . "'>Accept</a> | ";
                    echo "<a href='deny_report.php?id=" . $row["id"] . "'>Deny</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No reported items found</td></tr>";
            }

            $conn->close();
            ?>
        </table>
    </main>
</body>
</html>
