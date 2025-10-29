<?php
// Enable error reporting (you can turn this off later)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection settings
$servername = "localhost";
$username = "root"; // change if you have another username
$password = "";     // change if your DB has a password
$dbname = "tokyorolls";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form inputs
    $first_name = htmlspecialchars(trim($_POST['first_name']));
    $last_name  = htmlspecialchars(trim($_POST['last_name']));
    $email      = htmlspecialchars(trim($_POST['email']));
    $subject    = htmlspecialchars(trim($_POST['subject']));
    $message    = htmlspecialchars(trim($_POST['message']));

    // Validate required fields
    if (empty($first_name) || empty($last_name) || empty($email) || empty($subject) || empty($message)) {
        echo "All fields are required!";
        exit;
    }

    // Prepare and insert into database
    $stmt = $conn->prepare("INSERT INTO contact (first_name, last_name, email, subject, message) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $first_name, $last_name, $email, $subject, $message);

    if ($stmt->execute()) {
        // Redirect to Thank You page
        header("Location: thank-you.html");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid Request.";
}
?>
