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

        <div class="icon upload">
        
        <span>
            <a href="upload.php">
            <i class="fa-solid fa-upload icon"></i>
            </a>
        </span>
        <div class="tooltip">
                Upload Notes
        </div>
        </div>

        <div class="icon profile">
        
        <span>
            <a href="profile.php">
            <i class="fas fa-user"></i>
            </a>
        </span>
        <div class="tooltip">
                Profile
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
