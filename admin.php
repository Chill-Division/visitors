<?php
// 1. Password authentication (Basic - Enhance for production)
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['password'])) {
    $enteredPassword = $_POST['password'];
    if ($enteredPassword == $adminPassword) {
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // 3. Fetch and display visitor activity
        $sql = "SELECT * FROM visitors ORDER BY timestamp DESC"; 
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<h2>Visitor Activity</h2>";
            echo "<table border='1'>";
            echo "<tr><th>Name</th><th>Contact #</th><th>Company</th><th>Visiting</th><th>Sign-In Time</th><th>Sign-Out Time</th></tr>";
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["contact"] . "</td>";
                echo "<td>" . $row["company"] . "</td>";
                echo "<td>" . $row["visiting"] . "</td>";
                echo "<td>" . $row["timestamp"] . "</td>";
                echo "<td>" . ($row["sign_out_timestamp"] ? $row["sign_out_timestamp"] : "N/A") . "</td>"; 
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No visitor activity found.";
        }

        $conn->close();
    } else {
        echo "Incorrect password. Access denied.";
    }
} else {
    // 4. Display password prompt
    ?>
    <h2>Admin Access</h2>
    <form method="post">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Enter</button>
    </form>
    <?php
}
?>
