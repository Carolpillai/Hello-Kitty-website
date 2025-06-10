<?php
$servername = "localhost"; //  server name
$username = "root"; // database username
$password = ""; // database password
$dbname = "mysql"; // database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password']; // Storing plain text (not secure)

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $first_name, $last_name, $email, $password);

    // Check if email already exists
    $checkEmail = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $checkEmail->store_result();

    if ($checkEmail->num_rows > 0) {
        echo "Email already registered.";
    } else {
        // Execute the prepared statement
        if ($stmt->execute()) {
            // Registration successful, redirect to index.html
            header("Location: index.html");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    }
    

    $checkEmail->close();
    $stmt->close();
}
$conn->close();
?>