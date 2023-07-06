<?php
// Include the database connection file
include 'db_connect.php';

// Check if the postId parameter is provided
if (isset($_POST['postId'])) {
  $postId = $_POST['postId'];
  $userId = $_SESSION['userid'];

  // Check if the user has already liked the post
  $sql = "SELECT COUNT(*) AS liked FROM LIKES WHERE PostId = ? AND UserId = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ss", $postId, $userId);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();

  // Return true if the user has already liked the post, false otherwise
  echo ($row['liked'] > 0) ? "true" : "false";

  // Close the database connection
  $stmt->close();
  $conn->close();
}
?>
