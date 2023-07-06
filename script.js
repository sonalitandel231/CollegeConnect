let post_list = document.getElementsByClassName('post_list')[0];

postHtml = `
    <div class="post_header">
      <div class="p_inner">
        <img class="post_profile" src="" alt="Posted Person's Profile Pic">
        <p class="post_name"></p>
      </div>
    </div>
    <div class="p_image">
      <img class="post_img" src="" alt="Posted Image">
    </div>
    <div class="comment_section">  
      <div class="input_box">
        <input class="inpt_c" placeholder="Add a comment..." type="text" name="comment">
      </div>
      <div class="c_txt"><p>Post</p></div>
    </div>
  
`;

// Function to create post
function createPost(post) {
  let postElement = document.createElement('div');
  postElement.classList.add('post');
  postElement.innerHTML = postHtml;
  postElement.getElementsByClassName('post_profile')[0].src = post.profile;
  postElement.getElementsByClassName('post_name')[0].innerHTML = post.name;
  postElement.getElementsByClassName('post_img')[0].src = post.image;
  post_list.appendChild(postElement);
}










