const reader = new FileReader();

const inputFile = document.querySelector("#preview-cart");
setTimeout(() => {
  inputFile.style.width = "45vw";
  let height = document.querySelector("#preview-cart").clientHeight;
  if (height > 500) {
    inputFile.style.width = "36vw";
  }
  if (height > 800) {
    inputFile.style.width = "22vw";
  }
  if (height > 1100) {
    inputFile.style.width = "11vw";
  }
  inputFile.style.visibility = "visible";
  inputFile.style.borderRadius = "0.5rem";
}, 100);

changeHandler = (event) => {
  if (
    event.target.files[0].type !== "image/png" &&
    event.target.files[0].type !== "image/jpeg" &&
    event.target.files[0].type !== "image/gif"
  ) {
    alert("Only png, jpg and gif files are allowed");
    return;
  }
  reader.readAsDataURL(event.target.files[0]);

  reader.onload = (ev) => {
    inputFile.style.visibility = "hidden";

    Promise.resolve(ev.target.result).then((res) => {
      document.querySelector("#preview-cart").src = ev.target.result;
    });

    setTimeout(() => {
      inputFile.style.width = "45vw";
      let height = document.querySelector("#preview-cart").clientHeight;
      if (height > 500) {
        inputFile.style.width = "36vw";
      }
      if (height > 800) {
        inputFile.style.width = "22vw";
      }
      if (height > 1100) {
        inputFile.style.width = "11vw";
      }
      inputFile.style.visibility = "visible";
      inputFile.style.borderRadius = "0.5rem";
    }, 100);
  };
};

const triggerInput = document.querySelector("#file-cart");
triggerInput.addEventListener("change", changeHandler);

inputFile.addEventListener("click", () => {
  triggerInput.click();
});

const createCart = document.querySelector("#create-cart");
createCart.addEventListener("click", async (e) => {
  e.stopPropagation();

  const title = document.querySelector("#name-of-cart").value;
  const description = document.querySelector("#about-main-cart").value;
  const text = document.querySelector("#main-cart-text").value;
  let image = document.querySelector("#file-cart").files[0];

  const formData = new FormData();

  // get post id
  const url = window.location.href;
  const postId = url.split("/").pop();

  formData.append("post_id", postId);
  formData.append("name", title);
  formData.append("description", description);
  formData.append("text", text);

//   console.log(image);

  if (image == undefined) {
    image = document.querySelector("#preview-cart").src;
    const fileName = image.split("/").pop();
    formData.append("image", fileName);
  } else {
    formData.append("image", image);
  }

//   console.log(formData);

    await fetch(`/server/index.php/editpost`, { method: "POST", body: formData })
      .then((res) => res.json())
      .then((data) => {
        // console.log(data);
        if (data.status == 200) {
          window.location.href = "/";
        }
      });
});
