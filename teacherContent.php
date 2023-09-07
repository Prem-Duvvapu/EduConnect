<?php
// Retrieve form data
session_start();

$uname = $_SESSION["user_name"];


$presence = $_POST['presence'];
$slots = $_POST['slots'];
$timeSlots = array();
$studentNumbers = array();

// Retrieve time slot data
for ($i = 1; $i <= $slots; $i++) {
    $startTime = $_POST['start_time_' . $i];
    $endTime = $_POST['end_time_' . $i];
    $students = $_POST['students_' . $i];

    // Add time slot data to arrays
    $timeSlots[] = ($startTime && $endTime) ? "$startTime-$endTime" : null;
    $studentNumbers[] = $students ? $students : null;
}

// Insert data into the database table
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute the SQL statement
$stmt = $conn->prepare("INSERT INTO slotbooking (id,name,presence, nslots, slot1, slot2, slot3, slot4, slot5, ns1, ns2, ns3, ns4, ns5) VALUES (?,?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

// Concatenate time slots and student numbers
// Assign the time slots and student numbers from the arrays to separate variables
$timeSlot1 = $timeSlots[0] ?? null;
$timeSlot2 = $timeSlots[1] ?? null;
$timeSlot3 = $timeSlots[2] ?? null;
$timeSlot4 = $timeSlots[3] ?? null;
$timeSlot5 = $timeSlots[4] ?? null;

$studentNumber1 = $studentNumbers[0] ?? null;
$studentNumber2 = $studentNumbers[1] ?? null;
$studentNumber3 = $studentNumbers[2] ?? null;
$studentNumber4 = $studentNumbers[3] ?? null;
$studentNumber5 = $studentNumbers[4] ?? null;

// Prepare and execute the SQL statement
$stmt = $conn->prepare("INSERT INTO slotbooking (name,presence, nslots, slot1, slot2, slot3, slot4, slot5, ns1, ns2, ns3, ns4, ns5) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssssssss",$uname, $presence, $slots, $timeSlot1, $timeSlot2, $timeSlot3, $timeSlot4, $timeSlot5, $studentNumber1, $studentNumber2, $studentNumber3, $studentNumber4, $studentNumber5);
$stmt->execute();

// Close the statement and connection
$stmt->close();
$conn->close();
// ...
?>