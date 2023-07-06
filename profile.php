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

$uid = $_GET['id'];

$sql = $conn->prepare("SELECT * FROM `users` WHERE `ID` = ?");
$sql->bind_param("s", $uid);
$sql->execute();
$result = $sql->get_result();

// Fetch the user details
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $email = $row['Email'];
    $name = $row['Name'];
    $dept = $row['Department'];
    $yos = $row['Year of Study'];
    $uname = $row['Username'];
    
    echo $email . ' ' . $name . ' ' . $dept . ' ' . $yos . ' ' . $uname;
} else {
    echo "No user found";
}

$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class connect | Profile</title>
    <link rel="stylesheet" href="style.css">

    <!-- Linking fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>
<body>
<header>
    <div class="header_container">
        <div class="branding">
        <a href="#"><img class="logo" src="./icons/logo.png" alt="Logo"></a> 
        </div>

        <div class="iconbar">


            <div class="icon home">
            <span>
                <a href="index.php">
                <i class="fas fa-home"></i>
                </a>
            </span>
            <div class="tooltip">
                    Home
            </div>
            </div>

          <div class="icon addpost">
            
            <span>
              <a href="addpost.php">
              <i class="fas fa-plus" id="add_post"></i>
              </a>
            </span>
            <div class="tooltip">
                  Add Post
            </div>
          </div>

          <div class="icon classroom">
            
            <span>
              <a href="classroom.php">
              <i class="fa-solid fa-users-rectangle icon"></i>
              </a>
            </span>
            <div class="tooltip">
                  Classroom
            </div>
          </div>

          

          <div class="icon ">
          <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
              <span>
              <button type="submit" name="logout"><i class="fa-solid fa-right-from-bracket"></i></button>
              </span>
              <div class="tooltip">
                    Logout
              </div>
            
            </form>
        </div>

      </div>
</header>
<section class="main-container">
    <div class="profwrap">
        
        <div class="profdetails">
            <div class="profimg">
                <h2><?php echo $uname; ?></h2>
                <img src="retrived.php?id=<?php echo $uid ?>" alt="profile">
            </div>
            <h3>I am  <?php echo $name; ?></h3>
            <h3>I am currently studying in <?php echo $yos; ?></h3>
            <h3>My specialization: <?php echo $dept; ?></h3>
            <h3>Mail me at <?php echo $email; ?></h3>
        </div>
    </div>
</section>
</body>
</html>