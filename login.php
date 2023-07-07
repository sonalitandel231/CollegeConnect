<?php
$showError = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'db_connect.php';

    $username = $_POST["username"];
    $pwd = $_POST["password"]; 
    
    $stmt = $conn->prepare("SELECT * FROM `USERS` WHERE `USERNAME` = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result && $result->num_rows == 1) {
        $row = $result->fetch_assoc();
        
        if ($pwd===$row['Password']){ 
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['userid'] = $row['ID'];
            $_SESSION['username'] = $row['Username'];
            $_SESSION['isRep']=false;
            header("location: index.php");
            exit();
        } else {
            $showError = "Invalid Credentials";
        }
    } else {
        $showError = "Invalid Credentials";
    }
}

if ($showError) {
  echo "<script>alert('$showError');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
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
      background-image: url('GettyImages-1138392157-1260x709.jpg');
      background-size: cover;
      height: 100vh;

  background-position: center;
      background-repeat: no-repeat;
      margin: 0;
      padding: 0;
    }
   .body after{
    position: absolute;
  content: '';
  top: 0;
  left: 0;
  height: 100%;
  width: 100%;
  background: rgba(0,0,0,0.7);
   }
    h2 {
      margin: 50px;
      text-align: center;
      color: #000000;
    }
   form {
    width: 250px;
    padding: 20px;
    display: flex;
    flex-direction: column;
    justify-content: 200px; /* Adjust the spacing between form elements */
     /* Center the form vertically */
    height: 400px; /* Set the height of the form */
    margin: 0 auto;
    background-color: transparent;
    border-radius: 5px;
    box-shadow: 0 0 5px rgb(0, 0, 0);
  }
    

    label {
      
  display: block;
  margin-bottom: 5px;
  color: #000000;
  text-transform: uppercase; /* Capitalize the labels */
  font-weight: bold; /* Make the labels bold */
}


input[type="text"],
input[type="password"] {
      width: 80%;
      padding: 8px;
      margin: 10px;
      display: block;
      border: 1px solid #000000;
      border-radius: 4px;
      background-color: transparent;
      background-position: left center;
      background-repeat: no-repeat;
      background-size: 30px;
      
      background-size: 20px 20px; /* Set the background color to transparent */
}


    .button-container {
   
      display: flex;
    flex-direction: column; /* Change flex direction to column */
    align-items: center; /* Center align the buttons vertically */
    margin-top: 20px;
    }
    
    input[type="submit"]:hover {
    background-color: #555;
    transform: scale(1.05); /* Add a slight scale effect on hover */
  }

    input[type="submit"],
    button {
      width: 100%; /* Set the buttons to occupy 100% width */
    padding: 10px;
    background-color: #333;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
      
      
    }
    input[type="submit"]:hover,
  button:hover {
    background-color: #555;
    transform: scale(1.05); /* Add a slight scale effect on hover */
  }
    button a {
  
      text-decoration: none;
      color: #fff;
    }

    input[type="submit"],
    button {
      width: 100%; /* Set the buttons to occupy 100% width */
    padding: 10px;
    background-color: #333;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
      
      
    }
  </style>
</head>
<body>
  <h2>Login</h2>
    <form action="login.php" method="POST">
      <label for="username">Username:</label>
      <input type="text" id="username" name="username"  placeholder="Enter username">
      <br>
      <label for="password">Password:</label>
      <input type="password" id="password" name="password"  placeholder="Enter password">
      <br>
      <input type="submit" value="Login" id="loginBtn">
    <div class="button-container">
      <span style="margin-top: 80px;margin-bottom: 20px;">Don't have an account?</span>
      <button><a href="signup.php">Signup</a></button>
    </div>
  </form>
</body>
<script>
  let uname = document.getElementById("username");
  let pwd = document.getElementById("password");

  let loginBtn = document.getElementById("loginBtn");

  loginBtn.addEventListener("click", function() {
    let uvalue = uname.value;
    let pvalue = pwd.value;

    // check if uvalue and pvalue are not empty
    if (!uvalue || !pvalue) {
      alert("Please don't leave any field empty!");
      event.preventDefault();
    }
  });

  document.getElementById("signupBtn").addEventListener("click", function() {
      event.preventDefault();
  });
</script>
</html>

