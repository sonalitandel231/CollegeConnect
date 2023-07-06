  // Function to handle the like action
  function likePost(postId) {
    console.log("Like button clicked. Post ID: " + postId);
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












