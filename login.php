<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
</head>
<body>
  <h2>Login</h2>
  <form action="login.php" method="POST">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>
    <br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    <br>
    <input type="submit" value="Login" id="loginBtn">
    <button><a href="signup.php">Signup</a></button>
  </form>
</body>
<script>
let uname=document.getElementById("username");
let pwd=document.getElementById("password");

let loginBtn=document.getElementById("loginBtn");

loginBtn.addEventListener("click",function(){
    let uvalue=uname.value;
    let pvalue=pwd.value;

    // check if uvalue and pvalue are not empty
    if(!uvalue || !pvalue){
        alert("Please donot leave any field empty!");
    }
}
);
</script>
</html>


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

