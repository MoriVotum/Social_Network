const reader = new FileReader();

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

const inputFile = document.querySelector("#preview-cart");
inputFile.addEventListener("click", () => {
  triggerInput.click();
});

let isInterestingActive = false;

const showInteresting = document.querySelector("#show-interesting");
showInteresting.addEventListener("click", (e) => {
  e.stopPropagation();
  const settings = document.querySelector(
    "#settings-content button:nth-child(2)"
  );
  if (settings.style.backgroundColor == "rgb(162, 161, 249)") {
    settings.style.backgroundColor = "#f1f1f1";
  } else {
    isInterestingActive = true;
    settings.style.backgroundColor = "rgb(162, 161, 249)";
  }
});

const createCart = document.querySelector("#create-cart");
createCart.addEventListener("click", async (e) => {
  e.stopPropagation();

  const title = document.querySelector("#name-of-cart").value;
  const description = document.querySelector("#about-main-cart").value;
  const text = document.querySelector("#main-cart-text").value;
  const image = document.querySelector("#file-cart").files[0];

  if (image == undefined) {
    alert("Please, add an image");
    return;
  }

  const formData = new FormData();
  formData.append("name", title);
  formData.append("description", description);
  formData.append("text", text);
  formData.append("image", image);

  // console.log(formData);

  await fetch("/server/index.php/post", { method: "POST", body: formData })
    .then((res) => res.json())
    .then((data) => {
      // console.log(data);
      if (data.status == 201) {
        window.location.href = "/";
      }
    });
});
