<?php
// Start the session
session_start();

// Check if the user is logged in
if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    include 'db_connect.php';

    // Retrieve the profile picture of the logged-in user
    $sql = "SELECT `Username` FROM `Users` WHERE ID = '$userId'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $uname = $row['Username'];

        
        echo $uname;
    } else {
        echo "Failed to retrieve the profile uname.";
    }

    mysqli_close($conn);
} else {
    echo "User not logged in.";
}
?>
