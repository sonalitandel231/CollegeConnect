<?php
session_start();

if (isset($_POST['logout'])) {
    // Perform logout actions
    session_unset();
    session_destroy();
    header("location: login.php");
    exit;
}

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: login.php");
    exit;
}

// Include the database connection file
include 'db_connect.php';

// Retrieve posts from the database
$sql = "SELECT * FROM `CLASSPOSTS`";
$result = $conn->query($sql);

// Array to store the retrieved posts
$posts = array();

// Fetch each post and add it to the posts array
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $userid = $_SESSION['userid'];

        // Retrieve the profile picture and username of the user who added the post
        $profileQuery = $conn->prepare("SELECT `PROFILEPIC`,`USERNAME` FROM `USERS` WHERE `ID` = ?");
        $profileQuery->bind_param("s", $userid);
        $profileQuery->execute();
        $profileResult = $profileQuery->get_result();

        if ($profileResult->num_rows > 0) {
            $profileRow = $profileResult->fetch_assoc();
            $username = $profileRow['USERNAME'];
            $profilePic = $profileRow['PROFILEPIC'];
        } 
        $post = array(
            'username' => $username,
            'userid' => $userid,
            'profilePic' => $profilePic,
            'postPic' => $row['Image'],
            'caption' => $row['Caption']
        );
        $posts[] = $post;
    }
}

// Close the database connection
$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">

    <!-- Linking fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <title>Class Connect | Classroom</title>
</head>
<body>
    
<header>
    <div class="header_container">
        <div class="branding">
        <a href="#"><img class="logo" src="./icons/logo.png" alt="Logo"></a> 
        </div>
        <div class="searchbar">
            <input class="search" placeholder="Search" type="search" name="" id="">
        </div>
        <div class="iconbar">
            <a href="index.php"><i class="fas fa-home icon"></i></a>
            <a href="upload.php"><i class="fa-solid fa-upload icon"></i></i></a>
            <a href="notes.php"><i class="fa-solid fa-book icon"></i></a>
         <img class="profile_icon" src="retrived.php" alt="Profile image">
        </div> 
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <button type="submit" name="logout">Logout</button>
        </form>
    </div>
</header>

<section class="main-container">

<div class="inner-container">
    <div class="left-setion">
        <div class="post_list">
        <?php
        foreach ($posts as $post) {
        
        echo '<div class="post">' .
        '<div class="post_header">' .
        '<div class="p_inner">' .
        '<img class="post_profile" src="data:image/jpeg;base64,' . base64_encode($profilePic) . '" alt="Posted Person\'s Profile Pic">' .
        '<p class="p_name">' . $post['username'] . '</p>' .
        '</div>' .
        '<i class="fa-solid fa-ellipsis-vertical threedots"></i>' .
        '</div>' .
        '<div class="p_image">' .
        '<img class="pp_full" src="data:image/jpeg;base64,' . base64_encode($post['postPic']) . '">' .
        '</div>' .
        '<div class="reaction_icon">' .
        '<div class="left_i">' .
        '<i class="far fa-comment"></i>' .
        '<i class="far fa-thumbs-up"></i>' .
        '</div>' .
        '<div class="rigts_i">' .
        '<i class="fa-regular fa-bookmark"></i>' .
        '</div>' .
        '</div>' .
        '<div class="comment_section">' .
        '<div class="input_box">' .
        '<p class="inpt_c" >' . $post['caption'] .'</p>' .
        '</div>' .
        '</div>';
        }
        ?>
    </div>
</div>

</section>


<script src="script.js"></script>
</body>
</html>

