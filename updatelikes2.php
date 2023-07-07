<?php
// Include the database connection file
include 'db_connect.php';

session_start();

// Check if the postId parameter is provided
if (isset($_POST['postId'])) {
  $postId = $_POST['postId'];
  $userId = $_SESSION['userid']; // Assuming you have the user's ID stored in the session

  // Check if the user has already liked the post
  $checkLikeQuery = $conn->prepare("SELECT * FROM `CLASSLIKES` WHERE `PostId` = ? AND `UserId` = ?");
  $checkLikeQuery->bind_param("ss", $postId, $userId);
  $checkLikeQuery->execute();
  $checkLikeResult = $checkLikeQuery->get_result();

  if ($checkLikeResult->num_rows > 0) {
    // User has already liked the post, return the current like count without updating
    $currentLikes = getLikesCount($postId);
    echo $currentLikes;
  } else {
    // User has not liked the post, proceed to update the like count
    // Update the like count in the database
    $sql = "UPDATE `CLASSPOSTS` SET `LIKES` = `LIKES` + 1 WHERE `ID` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $postId);
    $stmt->execute();

    // Insert the like into the LIKES table
    $insertLikeQuery = $conn->prepare("INSERT INTO `CLASSLIKES` (`PostId`, `UserId`) VALUES (?, ?)");
    $insertLikeQuery->bind_param("ss", $postId, $userId);
    $insertLikeQuery->execute();

    // Get the updated like count
    $updatedLikes = getLikesCount($postId);

    // Close the database connections
    $stmt->close();
    $insertLikeQuery->close();
    $conn->close();

    // Return the updated like count as the response
    echo $updatedLikes;
  }
}

// Function to get the current like count for a post
function getLikesCount($postId) {
  global $conn;
  $likesQuery = $conn->prepare("SELECT * FROM `CLASSPOSTS` WHERE `ID` = ?");
  $likesQuery->bind_param("s", $postId);
  $likesQuery->execute();
  $likesResult = $likesQuery->get_result();

  if ($likesResult->num_rows > 0) {
    $likesRow = $likesResult->fetch_assoc();
    return $likesRow['Likes'];
  }

  return 0;
}
?>
