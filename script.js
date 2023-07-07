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
