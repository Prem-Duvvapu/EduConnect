

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

if (isset($_GET["teacher"]) && isset($_GET["slot"])) {
  $selectedTeacher = $_GET["teacher"];
  $selectedSlot = $_GET["slot"];

  // Update the student count (ns1, ns2, ..., ns5) for the selected slot
  $updateSql = "UPDATE slotbooking SET ns$selectedSlot = ns$selectedSlot - 1 WHERE name = ?";
  $stmt = $conn->prepare($updateSql);
  $stmt->bind_param("s", $selectedTeacher);
  $stmt->execute();
  $stmt->close();

  // Redirect back to the slot_details.php page
  header("Location: slot_details.php?teacher=" . urlencode($selectedTeacher));
} else {
  echo "Error: Missing teacher or slot information.";
}

// Close the database connection
$conn->close();
?>
