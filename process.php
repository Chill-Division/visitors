<?php
// 1. MariaDB connection
require_once 'config.php';

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 2. Optional IP restriction (Illustrative)
// $allowedIPs = array('192.168.1.0/24'); // Replace with your allowed IP ranges
// $visitorIP = $_SERVER['REMOTE_ADDR'];
// if (!in_array($visitorIP, $allowedIPs)) {
//     die("Access denied. Please sign in from an authorized location.");
// }

// 3. Handle actions based on AJAX requests
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];

    if ($action == 'get_terms') {
        // Fetch terms from the database
        $sql = "SELECT term_text FROM terms";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<label><input type='checkbox' name='terms[]' value='{$row['term_text']}' required> {$row['term_text']}</label><br>";
            }
        } else {
            echo "No terms found.";
        }
    } 
    elseif ($action == 'sign_in') {
        // Handle sign-in form submission
        $name = $_POST['name'];
        $contact = $_POST['contact'];
        $company = $_POST['company'];
        $visiting = $_POST['visiting'];
        $timestamp = date('Y-m-d H:i:s'); 

        $sql = "INSERT INTO visitors (name, contact, company, visiting, timestamp) 
                VALUES ('$name', '$contact', '$company', '$visiting', '$timestamp')";

        if ($conn->query($sql) === TRUE) {
            echo "Sign-in successful!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    elseif ($action == 'search_for_sign_out') {
        // Handle sign-out search
        $searchTerm = $_POST['searchTerm'];
        $today = date('Y-m-d');

        $sql = "SELECT id, name FROM visitors 
                WHERE name LIKE '$searchTerm%' AND DATE(timestamp) = '$today' AND sign_out_timestamp IS NULL"; 
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<button type='button' class='sign-out-button' data-visitor-id='{$row['id']}'>{$row['name']}</button><br>";
            }
        } else {
            echo "No matching visitors found.";
        }
    }
    elseif ($action == 'sign_out') {
        // Handle sign-out action
        $visitorId = $_POST['visitorId'];
        $signoutTimestamp = date('Y-m-d H:i:s');

        $sql = "UPDATE visitors SET sign_out_timestamp = '$signoutTimestamp' WHERE id = $visitorId";

        if ($conn->query($sql) === TRUE) {
            echo "Sign-out successful!"; 
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>
