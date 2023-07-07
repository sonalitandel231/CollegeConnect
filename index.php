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
$sql = "SELECT * FROM `POSTS`";
$result = $conn->query($sql);


// Array to store the retrieved posts
$posts = array();

// Fetch each post and add it to the posts array
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $userid = $row['Userid'];

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
            'postPic' => $row['Postpic'],
            'caption' => $row['Caption'],
            'postId'=>$row['Postid'],
            'totallikes'=>$row['Likes']
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

    <title>Class Connect</title>
</head>
<body>
    
<header>
    <div class="header_container">
        <div class="branding">
        <a href="about.php"><img class="logo" src="./icons/logo.png" alt="Logo"></a> 
        </div>

        <div class="iconbar">

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

          <div class="icon profile">
            
            <span>
              <img src="retrived.php?id=<?php echo $_SESSION['userid']; ?>" class="profile_icon" alt="Profile pic">
              </a>
            </span>
            <div class="tooltip">
                  Hello <?php echo $_SESSION['username']; ?>
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

<div class="inner-container">
    <div class="left-section">
          <div class="post_list">
          <?php
            foreach ($posts as $post) {
            $userid = $post['userid'];
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
            '<div class="reaction_icon">
              <div class="left_i">
                <i class="far fa-comment" onclick="fetchComments(' .  $post['postId'] .')"></i>
                <i class="far fa-thumbs-up" onclick="likePost(' .  $post['postId'] .')"></i>
                <span id="like-count-'. $post['postId'] .'">'.$post['totallikes'].'</span> Likes
              </div>
            </div>' . '<div class="p_caption">' .
            '<p class="p_capt">' . $post['caption'] . '</p>' .
            '</div>' .
            '<div class="comment_section">
              <div class="input_box">
                <input type="text" class="inpt_c comment-input" data-postid="'.$post['postId'].'" placeholder="Add a comment...">
              </div>
              <div class="c_txt">
                <button class="post-comment-btn" data-postid="'.$post['postId'] .'">Post</button>
              </div>
            </div>
            </div>';
          }
          ?>
          </div>
    </div>

    <div class="right-section">
      <div class="comments-container">
       
      </div>
    </div>
</div>



</section>
<script>
  function likePost(postId) {
  // Send an AJAX request to check if the user has already liked the post
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "check_like.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      var alreadyLiked = xhr.responseText;

      if (alreadyLiked === "true") {
        // User has already liked the post, show a message or perform any other action
        console.log("You have already liked this post.");
      } else {
        // User has not liked the post, proceed to update the like count
        updateLikeCount(postId);
      }
    }
  };
  xhr.send("postId=" + postId);
}

function updateLikeCount(postId) {
  // Send an AJAX request to update the like count in the database
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "update_likes.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      // Update the like count on the page
      var likeCountElement = document.getElementById("like-count-" + postId);
      likeCountElement.textContent = xhr.responseText;
    }
  };
  xhr.send("postId=" + postId);
}

// Event listener for posting a comment
document.addEventListener('click', function(event) {
  if (event.target.classList.contains('post-comment-btn')) {
    const postId = event.target.dataset.postid;
    const commentInput = document.querySelector('.comment-input[data-postid="' + postId + '"]');
    const comment = commentInput.value.trim();
    
    if (comment !== '') {
      // Send an AJAX request to add the comment
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "add_comment.php", true);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
          // Handle the response
          const response = xhr.responseText;
          if (response === 'success') {
            // Comment added successfully, update the UI or perform any necessary actions
            alert('Comment added successfully');
            
            // Reset the comment input field
            commentInput.value = '';
          } else {
            // Comment failed to add, handle the error or display a message to the user
            alert('Failed to add comment');
          }
        }
      };
      xhr.send("postId=" + postId + "&comment=" + encodeURIComponent(comment));
    }
  }
});

function fetchComments(postId) {

  console.log(postId);
  console.log("fetching");

  // Send an AJAX request to a PHP script that will fetch the comments from the database
  const xhr = new XMLHttpRequest();
  xhr.open('GET', `fetch_comments.php?Postid=${postId}`, true);
  xhr.onload = function() {
    if (xhr.status === 200) {
      const comments = JSON.parse(xhr.responseText);
      displayComments(comments); // Implement a function to display the comments
    }
  };
  xhr.send();
}

function displayComments(comments) {


  const commentsContainer = document.querySelector('.comments-container');

  commentsContainer.style.visibility="visible";

  // Clear the container before adding new comments
  commentsContainer.innerHTML = '';

  // Loop through the comments and create HTML elements to display them
  comments.forEach(comment => {

    const singleComment=document.createElement('div');
    singleComment.classList.add('single-comment');

    const commentInfo = document.createElement('div');
    commentInfo.classList.add('comment-info');

    const inner=document.createElement('div');
    inner.classList.add('p_inner');

    const commentText = document.createElement('div');
    commentText.classList.add('comment-text');
    commentText.textContent = comment['comment'];

    const userId = comment['userId'];

    
    
    const commentProfile = document.createElement('img');
    commentProfile.classList.add('comment-person-pic');
    
    commentProfile.src=`retrived.php?id=${userId}`;
    inner.appendChild(commentProfile);

    // Send an AJAX request to the PHP script that retrieves the username
    const xhr = new XMLHttpRequest();
    xhr.open('GET', `retriveUsername.php?id=${userId}`, true);
    xhr.onload = function() {
      if (xhr.status === 200) {
        const username = document.createElement('h3');
        username.classList.add('comment-username');
        username.textContent = xhr.responseText;
        inner.appendChild(username);
      }
    };
    xhr.send();

    commentInfo.appendChild(inner);
    

    // Add the comment info to the container
    singleComment.appendChild(commentInfo);
    const brtag=document.createElement('br');
    singleComment.appendChild(brtag);
    singleComment.appendChild(brtag);
    singleComment.appendChild(commentText);
    commentsContainer.appendChild(singleComment);
  });
}

</script>
</body>
</html>

