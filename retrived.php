<?php
// Start the session
session_start();

// Check if the user is logged in
if (isset($_SESSION['loggedin'])) {
    $userId = $_SESSION['userid'];

    include 'db_connect.php';

    // Retrieve the profile picture of the logged-in user
    $sql = "SELECT `PROFILEPIC` FROM `USERS` WHERE ID = '$userId'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $profilePic = $row['PROFILEPIC'];

        // Set the appropriate header for the image
        header("Content-type: image/jpeg");

        // Output the profile picture
        echo $profilePic;
    } else {
        echo "Failed to retrieve the profile picture.";
    }

    mysqli_close($conn);
} else {
    echo "User not logged in.";
}
?>
