<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if username and password are received
if(isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
	

    // Prepare SQL statement
    $stmt = $conn->prepare("SELECT * FROM studentlogin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];

        // Display the hashed password for debugging
        echo "Stored hashed password: " . $hashed_password . "<br>";

        // Verify the password
        if ($hashed_password==$password) {
            // Password is correct, do further actions here
            header("Location: student.php");
        } else {
            // Password is incorrect
            echo "Invalid username or password.";
        }
    } else {
        // No user found with the given username
        echo "Invalid username or password.";
    }

    // Close the prepared statement and the database connection
    $stmt->close();
    $conn->close();
}
?>