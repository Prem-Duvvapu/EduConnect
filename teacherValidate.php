
<?php
// Assuming the database credentials
$hostname = "localhost";
$username = "root";
$password = "";
$database = "login";

// Establish a connection to the database
$conn = new mysqli($hostname, $username, $password, $database);

// Check the database connection
if ($conn->connect_error) {
  die("Database connection failed: " . $conn->connect_error);
}


// Get the submitted form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $password = $_POST["password"];

  // Prepare the SQL statement
  $stmt = $conn->prepare("SELECT * FROM teacherlogin WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();

  // Check if the username exists in the database
  if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $storedPassword = $row["password"];

    // Verify the password
    if ($password==$storedPassword) {
      // Redirect to the teacher dashboard page on successful login
      //Session starting for sending username for the further files.
      session_start();
      $_SESSION["user_name"]=$username;
      header("Location: teacherDashboard.html"); // Replace with the URL of the teacher dashboard page
      exit();
    }
  }

  // Redirect back to the login page with an error message

  header("Location: teacherlogin.html?error=1");
  exit();
}

// Close the database connection
$conn->close();
?>