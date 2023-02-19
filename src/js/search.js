const dashboard = document.getElementsByClassName("wrapper");

let limit = 5;
// let offset = 0;

const utf8_decode = (str) => {
    return decodeURIComponent((str));
}

const createArcticle = async () => {

  console.log("search by ...");
  
  //get url params
  const currentUrl = (window.location.href);
//   console.log(currentUrl);

  // get name from url
  const name = currentUrl.split("?=")[1];
//   console.log(name);
  const sort = currentUrl.split("?=")[2];
//   console.log(sort);

  const res = await fetch(`/server/index.php/postsbyname?=${name}?=${sort}?=${limit}`, {
    method: "GET",
  });

  limit += 5;

  const data = await res.json();

//   console.log(data);

  dashboard[0].innerHTML = "";

  const cookie = document.cookie;
  const cookieArr = cookie.split("=");
  const id_and_avatar = cookieArr[2];
  let id = null;
  if (id_and_avatar == undefined) {
    id = null;
  } else {
    const id_text = id_and_avatar.split(" ")[0];
    id = id_text.split(";")[0];
  }

  for (let i = 0; i < data.length; i++) {
    let delete_cart = "";

    if (data[i].id_client == id) {
      let card_id = data[i].id;
      delete_cart = `<img src="/src/img/utility/delete.svg" class="delete_card" onclick="deleteCard(${card_id})" alt="" />`;
    }

    dashboard[0].innerHTML += `
    <div class="cart_${data[i].id}">
    <div class="img-and-login">
      <img
      class="img-in-cart"
      src="/server/images/posts/${data[i].image}"
      alt=""
      />
      <div class="login-and-delete">
        <a href="/" class="login"> ${data[i].login} </a>
        ${delete_cart}
      </div>
    </div>
      <div class="info">
        <h2>${data[i].name}</h2>
        <p>${data[i].description}</p>
        <div class="info-bottom">
          <div class="info-bottom-left">
          <img src="/src/img/utility/eye.svg" class="eye_img" alt="" />
          <p class="viewed">${data[i].viewed}</p>
          </div>
          <a href="/post/${data[i].id}" class="more">Подробнее</a>
        <div class="info-bottom-right">
        <img src="/src/img/utility/comments.svg" class="comments_img" alt="" />
        <p class="comments">${data[i].comments_count}</p>
      </div>
    </div>
  </div> 
  </div>`;
  }
//   if (document.scrollHeight == document.offsetHeight) createArcticle();
};

createArcticle();

setTimeout(() => {
    if (document.scrollHeight == document.offsetHeight) createArcticle();
}, 100);

window.addEventListener("scroll", async () => {
  const scrollPosition = window.scrollY;
  const header = document.querySelector("header");

  const headerHeight = header.offsetHeight;
  const documentHeight = document.documentElement.offsetHeight;
  const clientHeight = document.documentElement.clientHeight;

  if (documentHeight - scrollPosition - headerHeight - clientHeight < 10) {
    createArcticle();
  }
});

function deleteCard(x) {
  // console.log("delete");
  // console.log(x);
  fetch(`/server/index.php/deletepost/${x}`, {
    method: "DELETE",
  })
    .then((res) => res.json())
    .then((data) => {
      // console.log(data);
      if (data.status == "200") {
        // console.log(x);
        const deleteElement = document.querySelectorAll(`.cart_${x}`);
        for (let i = 0; i < deleteElement.length; i++) {
          deleteElement[i].remove();
        }
      }
    });
}