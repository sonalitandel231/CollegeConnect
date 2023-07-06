<?php
include 'db_connect.php';

session_start();

// Check if the postId parameter is provided
if (isset($_GET['Postid'])) {
  $postId = $_GET['Postid'];
  $userId = $_SESSION['userid'];

  $checkLikeQuery = $conn->prepare("SELECT * FROM `COMMENTS` WHERE `PostId` = ? AND `UserId` = ?");
  $checkLikeQuery->bind_param("ss", $postId, $userId);
  $checkLikeQuery->execute();
  $checkLikeResult = $checkLikeQuery->get_result();

  // Fetch the comments from the database
  $comments = array();
  while ($row = $checkLikeResult->fetch_assoc()) {
    $comments[] = $row;
  }

  // Close the database connections
  $checkLikeQuery->close();
  $conn->close();

  // Return the comments as JSON
  echo json_encode($comments);
}
?>
