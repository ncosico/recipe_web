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

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Fetch the hashed password
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        // Verify the entered password against the stored hash
        if (password_verify($pass, $hashed_password)) {
            echo "Login successful! Welcome, " . htmlspecialchars($user) . ".";
            // Redirect to a different page or show a dashboard
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "User not found!";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
