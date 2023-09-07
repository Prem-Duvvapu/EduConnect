
<!DOCTYPE html>
<html>
<head>
  <title>Slot Details</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
      background-color: #f2f2f2;
    }

    h1 {
      text-align: center;
      color: #333;
    }

    .slots-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
    }

    .slot-info {
      border: 1px solid #ccc;
      border-radius: 4px;
      padding: 10px;
      margin: 10px;
      width: 200px;
      background-color: #fff;
      text-align: center;
    }

    .time-slot {
      font-weight: bold;
      margin-bottom: 5px;
    }

    .student-count {
      font-size: 14px;
      color: #666;
    }

    .book-button {
      margin-top: 5px;
      padding: 5px 10px;
      background-color: #4CAF50;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    .book-button:hover {
      background-color: #45a049;
    }
  </style>
</head>
<body>
  <h1>Slot Details</h1>
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

  // Retrieve slot details for the selected teacher from the slotbooking table
  if (isset($_GET["teacher"])) {
    $selectedTeacher = $_GET["teacher"];
    $sql = "SELECT * FROM slotbooking WHERE name = ?";
    
    // Prepare and execute the SQL statement with a parameter to prevent SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $selectedTeacher);
    $stmt->execute();
    $result = $stmt->get_result();

    // if ($result && $result->num_rows > 0) {
    //   echo "<h2>Teacher: $selectedTeacher</h2>";
    //   echo "<div class='slots-container'>";
    //   while ($row = $result->fetch_assoc()) {
    //     $slotNumber = 1;
    //     while ($row["slot$slotNumber"]) {
    //       echo "<div class='slot-info'>";
    //       echo "<div class='time-slot'>" . $row["slot$slotNumber"] . "</div>";
    //       echo "<div class='student-count'>Available: " . $row["ns$slotNumber"] . "</div>";
    //       echo "<button class='book-button' onclick=\"bookSlot('$selectedTeacher', $slotNumber)\">Book</button>";
    //       echo "</div>";
    //       $slotNumber++;
    //     }
    //   }
    //   echo "</div>";
    // }
    if ($result && $result->num_rows > 0) {
        echo "<h2>Teacher: $selectedTeacher</h2>";
        echo "<div class='slots-container'>";
        while ($row = $result->fetch_assoc()) {
          $slotNumber = 1;
          while ($row["slot$slotNumber"]) {
            echo "<div class='slot-info'>";
            echo "<div class='time-slot'>" . $row["slot$slotNumber"] . "</div>";
            $availableValue = $row["ns$slotNumber"];
            if ($availableValue > 0) {
              echo "<div class='student-count'>Available: " . $row["ns$slotNumber"] . "</div>";
              echo "<button class='book-button' onclick=\"bookSlot('$selectedTeacher', $slotNumber)\">Book</button>";
            } else {
              echo "<div class='student-count'>No Slots Available</div>";
              echo "<button class='book-button' disabled>Book (No Slots)</button>";
            }
            echo "</div>";
            $slotNumber++;
          }
        }
        echo "</div>";
      } 
    else {
      echo "No slot details available for the selected teacher.";
    }
  } else {
    echo "No teacher selected.";
  }

  // Close the database connection
  $stmt->close();
  $conn->close();
  ?>

  <script>
    function bookSlot(teacherName, slotNumber) {
      window.location.href = "book_slot.php?teacher=" + encodeURIComponent(teacherName) + "&slot=" + slotNumber;
    }
  </script>
</body>
</html>

