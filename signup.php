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

// Check if the file was uploaded successfully
if ($profilepic['error'] === UPLOAD_ERR_OK) {
    $tmpName = $profilepic['tmp_name'];

    // Read the contents of the uploaded file
    $fileData = file_get_contents($tmpName);

    // Prepare the SQL statement using parameter binding
    $stmt = $conn->prepare("INSERT INTO USERS (`NAME`, `DEPARTMENT`, `EMAIL`, `YEAR OF STUDY`, `USERNAME`, `PASSWORD`, `PROFILEPIC`) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $name, $dept, $email, $yos, $username, $password , $fileData);

    // Execute the SQL statement
    if ($stmt->execute()) {
        header("Location: login.php");
    } else {
        echo "Error inserting the record: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    // Handle the file upload error
    echo "Error uploading the file. Error code: " . $profilepic['error'];
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
</head>
<body>
    <div class="signup-container">
        <h2>Signup Form</h2>
        <form action="signup.php" method="POST" enctype="multipart/form-data">
            <div>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div>
                <label for="department">Department:</label>
                <select id="department" name="department" required>
                    <option value="">Select Department</option>
                    <option value="Computer Science">Computer Science</option>
                    <option value="Information Science">Information Science</option>
                    <option value="Mechanical">Mechanical</option>
                    <option value="Electronics">Electronics</option>
                    <option value="AIML">AIML</option>
                    <option value="Data Science">Data Science</option>
                </select>
            </div>
            <div>
                <label for="year">Year of Study:</label>
                <select id="year" name="year" required>
                    <option value="">Select Year</option>
                    <option value="First year">First Year</option>
                    <option value="Second year">Second Year</option>
                    <option value="Pre-final year">Third Year</option>
                    <option value="Final year">Fourth Year</option>
                </select>
            </div>
            <div>
                <label for="profile-pic">Profile Picture:</label>
                <input type="file" id="profile-pic" name="profile-pic" accept="image/*" required>
            </div>
            <div>
                <button type="submit" id="signupBtn">Signup</button>
            </div>
        </form>
    </div>
    <script src="signup.js"></script>
</body>

</html>

