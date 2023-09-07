
<!DOCTYPE html>
<html>
<head>
  <title>Student Dashboard</title>
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

    .teacher-list {
      list-style-type: none;
      padding: 0;
      max-width: 400px;
      margin: 20px auto;
    }

    .teacher-list-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 20px;
      border: 1px solid #ccc;
      border-radius: 4px;
      margin-bottom: 5px;
      background-color: #fff;
      cursor: pointer;
      transition: background-color 0.2s;
    }

    .teacher-list-item:hover {
      background-color: #f0f0f0;
    }

    .book-button {
      padding: 5px 10px;
      background-color: #4CAF50;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      transition: background-color 0.2s;
    }

    .book-button:hover {
      background-color: #45a049;
    }
  </style>
</head>
<body>
  <h1>Student Dashboard</h1>
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

  // Retrieve teacher data from the slotbooking table
  $sql = "SELECT DISTINCT name FROM slotbooking";
  $result = $conn->query($sql);

  if ($result && $result->num_rows > 0) {
    echo "<ul class='teacher-list'>";
    while ($row = $result->fetch_assoc()) {
      $teacherName = $row["name"];
      echo "<li class='teacher-list-item' onclick=\"bookSlot('$teacherName')\" onmouseover=\"showCursorPointer(this)\" onmouseout=\"showDefaultCursor(this)\">$teacherName";
      echo "<button class='book-button' onclick=\"bookSlot('$teacherName')\">Book Slot</button>";
      echo "</li>";
    }
    echo "</ul>";
  } else {
    echo "No teacher data available.";
  }

  // Close the database connection
  $conn->close();
  ?>

  <script>
    function bookSlot(teacherName) {
      window.location.href = "slot_details.php?teacher=" + encodeURIComponent(teacherName);
    }

    function showCursorPointer(element) {
      element.style.cursor = "pointer";
    }

    function showDefaultCursor(element) {
      element.style.cursor = "default";
    }
  </script>
</body>
</html>