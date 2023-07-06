<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
  $noteId = $_GET['id'];

  // Retrieve the file from the database
  $stmt = $conn->prepare("SELECT * FROM `NOTES` WHERE `ID` = ?");
  $stmt->bind_param("i", $noteId);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $fileData = $row['FILE'];

    // Set the appropriate headers for file download
    header('Content-Description: File Transfer');
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . $row['Title'] . '.pdf"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . strlen($fileData));

    // Output the file content
    echo $fileData;
    exit;
  } else {
    echo "File not found.";
  }
} else {
  echo "Invalid request.";
}
?>
