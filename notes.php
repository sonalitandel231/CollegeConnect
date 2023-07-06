<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
  header("location: login.php");
  exit;
}

include 'db_connect.php';

// Retrieve the PDF files from the database
$stmt = $conn->prepare("SELECT * FROM `NOTES`");
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Class Connect | Notes</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <div class="inner-container">
    <div class="notes-container">
      <h2>Notes</h2>
      <ul class="notes-list">
        <?php while ($row = $result->fetch_assoc()) : ?>
          <li>
            <a href="download.php?id=<?php echo $row['ID']; ?>"><?php echo $row['Title']; ?></a>
          </li>
        <?php endwhile; ?>
      </ul>
    </div>
  </div>
</body>

</html>
