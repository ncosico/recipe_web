<?php
// Connect to the MySQL database
$servername = "localhost";
$username = "root"; // Default username for XAMPP
$password = ""; // Default password for XAMPP
$dbname = "my_database"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form data securely
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $user = $_POST['username'];
    $pass = $_POST['password'];
    $email = $_POST['email'];

    // Hash the password
    $hashed_password = password_hash($pass, PASSWORD_DEFAULT); // Hash the password

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $user, $hashed_password, $email); // Bind the variables to the prepared statement

    // Execute the statement
    if ($stmt->execute()) {
        // Successful signup message with link to login
        echo "<h2>Sign Up Successful!</h2>";
        echo "<p>Welcome, " . htmlspecialchars($user) . "!</p>";
        echo "<p>You can now <a href='login.html'>log in</a>.</p>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
