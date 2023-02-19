function sendComment(post_id) {
  let comment = document.getElementById("comment-text").value;

  // console.log(comment);

  const formData = new FormData();
  formData.append("post_id", post_id);
  formData.append("comment", comment);

  // console.log(formData);

  const res = fetch("/server/index.php/comment", {
    method: "POST",
    body: formData,
  })
    .then((res) => res.json())
    .then((data) => {
      // console.log(data["status"]);

      if (data["status"] == 201) {
        let comment = document.getElementById("comment-text");
        comment.value = "";
        
        window.location.reload();
      }
    });

  // const data = res.json();

  // console.log(data);
}

function deletePost(post_id) {
  // console.log(post_id);

  // are you sure?
  const res =
    confirm("Are you sure you want to delete this post?") == true
      ? true
      : false;

  if (res == false) {
    return;
  }

  fetch(`/server/index.php/deletepost/${post_id}`, {
    method: "DELETE",
  })
    .then((res) => res.json())
    .then((data) => {
      // console.log(data);
      if (data.status == "200") {
        window.location.href = "/";
      }
    });
}

function editPost(post_id) {
  // console.log(post_id);
  window.location.href = `/edit_post/${post_id}`;
}

function createPost(post_id) {
  // console.log(post_id);
  window.location.href = `/create_same_post/${post_id}`;
}
