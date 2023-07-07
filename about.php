<?php
session_start();

if (isset($_POST['logout'])) {
    // Perform logout actions
    session_unset();
    session_destroy();
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<style>
body {
    font-family: Arial, sans-serif;
    background-color: #ffffff;
  }
  
  .header {
    background-color:black;
    padding: 20px;
    text-align: center;
  }
  
  .header h1 {
    color:red;
    font-size: 24px;
    margin: 0;
  }
  
  .container {
    max-width: 800px;
    padding: 20px;
    margin:120px 170px;
  }
  
  #intro {
    margin-top: 40px;
  }
  
  h2 {
    color:red;
    margin-bottom: 20px;
  }
  
  p {
    color:black;
    margin-bottom: 10px;
    line-height: 1.5;
  }
  
  .section-title {
    margin-top: 40px;
    margin-bottom: 20px;
    color: #333;
  }
  
  .table-container {
    width: 100%;
    overflow-x: auto; 
  }
  
  table {
    width: 100%;
    border-collapse: collapse;
    background-color: #ffffff;
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
  }
  
  th,
  td {
    padding: 12px;
    text-align: left;
    border: 1px solid #dddddd;
  }
  
  th {
    background-color: #f2f2f2;
    font-weight: bold;
  }
  
  td a {
    color: #007bff;
    text-decoration: none;
  }
  
  td a:hover {
    text-decoration: underline;
  }
  
  tr:nth-child(even) {
    background-color: #f9f9f9;
  }
</style>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Class Connect | About Us</title>
  <link rel="stylesheet" href="style.css">

  <!-- Linking fontawesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
<header>
    <div class="header_container">
        <div class="branding">
        <img class="logo" src="./icons/logo.png" alt="Logo">
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

 

    </div>
</header>

  <div class="inner-container">
  <div class="container">
    <div id="about-us">
      <h2>About Us</h2>
      <p>College is a time when many people form lifelong friendships. Living in dorms or spending time in shared classes and activities allows for socializing and bonding with peers. College memories often involve late-night conversations, group outings, and shared experiences that create strong friendships.</p>
      <p>College memories often revolve around classes and academic pursuits. Whether it's a particularly challenging course, an inspiring professor, or a breakthrough moment in understanding a complex concept, academic achievements and struggles play a significant role in college memories.</p>
      <p> College life often includes various celebrations and parties, whether it's a birthday party, graduation celebration, or themed parties organized by student groups. These events are opportunities to unwind, have fun, and create memories with friends.</p>
    </div>

    <div id="about-website">
      <h2>About our Website</h2>
      <p>
      ClassConnect is an inclusive online platform designed exclusively for the students of Sahyadri College community. It serves as a virtual hub for students to connect, engage, and enhance their educational experience.</p>
        <p>
        Through ClassConnect, students have the opportunity to share their experiences and ideas by posting pictures, engaging in discussions through comments, and expressing appreciation through likes for the posts shared by their peers. This fosters a sense of community and collaboration among the students, promoting a supportive and interactive learning environment.</p>

        <p>
        One of the key features of ClassConnect is the accessibility it offers to the virtual classroom. Students can seamlessly access their respective classrooms, where they can find relevant course materials, participate in discussions, and collaborate with their classmates. The virtual classroom serves as a centralized hub for academic activities, ensuring that students have easy access to important resources and updates related to their courses.</p>

        <p>
        Furthermore, ClassConnect provides a platform for easy note sharing. The representative, designated as the administrator, has the privilege of adding posts to the classroom and uploading notes. These notes can be accessed by all users, facilitating the efficient dissemination of study materials and encouraging collaborative learning.</p>

        <p>
        ClassConnect prioritizes the security and privacy of its users. Only students who are part of the Sahyadri College community are granted access to the website, ensuring a safe and exclusive online space for educational purposes.</p>

        <p>
        In summary, ClassConnect is a student-centric website that empowers the Sahyadri College community to connect, collaborate, and learn together. It offers a range of features such as photo sharing, commenting, liking, virtual classroom access, and note sharing, facilitating a dynamic and engaging educational experience for all users.</p>
    </div>

    <div id="team">
      <h2>Our Team</h2>
      <table>
        <tr>
          <th>Name</th>
          <th>USN</th>
          <th>LinkedIn Account</th>
        </tr>
        <tr>
          <td>Shruthi S</td>
          <td>4SF20CS141</td>
          <td><a href="https://www.linkedin.com/in/shruthi-s-4a58ba202">LinkedIn</a></td>
        </tr>
        <tr>
          <td>Deeksha</td>
          <td>4SF20CS028</td>
          <td><a href="http://linkedin.com/in/deeksha-devadiga-b206a8248">LinkedIn</a></td>
        </tr>
        <tr>
          <td>Sonali Tandel</td>
          <td>4SF20CS149</td>
          <td><a href="https://www.linkedin.com/in/sonali-g-tandel-6b814422a">LinkedIn</a></td>
        </tr>
        <tr>
          <td>Varsha</td>
          <td>4SF20CS173</td>
          <td><a href="https://www.linkedin.com/in/varsha-kalas-8b7a21222">LinkedIn</a></td>
        </tr>
      </table>
    </div>

    </div>
  </div>
  </div>
</body>

</html>