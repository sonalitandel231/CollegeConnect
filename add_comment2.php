<?php
// Include the database connection file
include 'db_connect.php';

session_start();

// Check if the postId and comment parameters are provided
if (isset($_POST['postId']) && isset($_POST['comment'])) {
  $postId = $_POST['postId'];
  $userId = $_SESSION['userid'];
  $comment = $_POST['comment'];

  // Add the comment to the database
  $sql = "INSERT INTO `COMMENTS2` (`PostId`, `UserId`, `Comment`) VALUES (?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sss", $postId, $userId, $comment);
  $stmt->execute();

  // Check if the comment was added successfully
  if ($stmt->affected_rows > 0) {
    // Comment added successfully
    echo 'success';
  } else {
    // Failed to add comment
    echo 'error';
  }

  // Close the statement
  $stmt->close();
}

// Close the database connection
$conn->close();
?>
