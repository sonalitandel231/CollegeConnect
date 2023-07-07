<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
    include 'db_connect.php';

$name = $_POST['name'];
$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];
$dept = $_POST['department'];
$yos = $_POST['year'];

$profilepic = $_FILES['profile-pic'];

// $prevPassword = $password;
// $prevemail=$email;
// $prevyos=$yos;
// $prevname=$name;
// $prevdept=$dept;


// Check if the file was uploaded successfully
if ($profilepic['error'] === UPLOAD_ERR_OK) {
    $tmpName = $profilepic['tmp_name'];

    // Read the contents of the uploaded file
    $fileData = file_get_contents($tmpName);

    // Prepare the SQL statement using parameter binding
    $stmt = $conn->prepare("INSERT INTO USERS (`NAME`, `DEPARTMENT`, `EMAIL`, `YEAR OF STUDY`, `USERNAME`, `PASSWORD`, `PROFILEPIC`) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $name, $dept, $email, $yos, $username, $password , $fileData);

    // Execute the SQL statement
    try{
    $stmt->execute();
        header("Location: login.php");
    }
    catch (mysqli_sql_exception $e) {
        if ($e->getCode() === 1062) {
            // Duplicate entry error
            $errorMessage = "Username is already taken. Please choose a different username.";
        } else {
            // Other database error
            $errorMessage='An error occurred while processing your request. Please try again later.';
        }
    }

    // Close the statement
    $stmt->close();
} else {
    // Handle the file upload error
    echo "<script>
    alert('An error occurred while uploading the file.');
    </script>";
}

$conn->close();

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Signup Form</title>
  <style>
    @font-face {
      font-family: 'VSCodeIcons';
      src: url('') format('woff2');
      /* Update the font file path and format if necessary */
    }

    @font-face {
      font-family: 'Bell MT';
      src: url('path-to-bell-mt-font/BellMT.ttf');
      /* Replace 'path-to-bell-mt-font' with the actual path to your font file */
    }

    body {
      font-family: 'Bell MT', Arial, sans-serif;
      background-size: cover;
      height: 100vh;
      background-position: center;
      background-repeat: no-repeat;
      margin: 0;
      padding: 0;
    }

    .signup-container {
      align-items: center;
      width: 335px;
      display: flex;
      flex-direction: column;
      padding: 20px;
      margin: 60px auto;
      background-color: transparent;
      border-radius: 5px;
      box-shadow: 0 0 5px rgb(0, 0, 0);
    }

    h2 {
      text-align: center;
      color: #000000;
    }

    label {
      margin-bottom: 5px;
      color: #000000;
      text-transform: uppercase;
      font-weight: bold;
    }

    input[type="text"],
    input[type="password"],
    input[type="email"] {
      width: 82.50%;
      padding: 8px;
      margin-top:10px;
      margin-bottom: 10px;
      border: 1px solid #000000;
      border-radius: 4px;
      background-color: transparent;
      background-position: left center;
      background-repeat: no-repeat;
      background-size: 15px 15px; /* Decrease the width of the placeholder */
    }

    input[type="file"],select {
      margin-top: 10px;
      width: 82.50%;
    }

    select {
      width: 87.20%;
      padding: 8px;
      margin-bottom: 10px;
      border: 1px solid #000000;
      border-radius: 4px;
      background-color: transparent;
    }
   

    button {
      width: 100%;
      padding: 10px;
      margin-top: 10px;
      background-color: #333;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    button:hover {
      background-color: #555;
      transform: scale(1.05);
    }
    #error{
        color: red;
    }

  </style>
</head>
<body>
  <div class="signup-container">
    <h2>Signup Form</h2>
    <form action="signup.php" method="POST" enctype="multipart/form-data">
      <div>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" placeholder="Enter your email">
      </div>
      <div>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="Enter your Email">
      </div>
      <div>
        <label for="username">Username:</label>
        
        <input type="text" id="username" name="username" placeholder="Enter your Username">
        <span id="error"><?php if (isset($errorMessage)): ?>
        <p><?php echo $errorMessage; ?></p>
        <?php endif; ?>
        </span>
      </div>
      <div>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Enter your Password">
      </div>
      <div>
        <label for="department">Department:</label>
        <select id="department" name="department">
          <option value="">Select Department</option>
          <option value="1">Computer Science</option>
          <option value="2">Information Science</option>
          <option value="3">Mechanical</option>
          <option value="4">Electronics</option>
          <option value="5">AIML</option>
          <option value="6">Data Science</option>
        </select>
      </div>
      <div>
        <label for="year">Year of Study:</label>
        <select id="year" name="year">
          <option value="">Select Year</option>
          <option value="1">First Year</option>
          <option value="2">Second Year</option>
          <option value="3">Third Year</option>
          <option value="4">Fourth Year</option>
        </select>
      </div>
      <div>
        <label for="profile-pic">Profile Picture:</label>
        <input type="file" id="profile-pic" name="profile-pic" accept="image/*">
      </div>
      <div>
        <button type="submit" id="signupBtn">Signup</button>
      </div>
    </form>
  </div>
</body>
<script src="signup.js"></script>
</html>

