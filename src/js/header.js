let isSearchActive = true;
const settings = document.querySelector(
  "#settings-content button:nth-child(3)"
);
settings.style.backgroundColor = "rgb(162, 161, 249)";

if (window.innerWidth < 550) {
  const search = document.querySelector(".search-header");
  search.style.cssText = `display: none;`;
}

window.addEventListener("resize", () => {
  const search = document.querySelector(".search-header");
  if (window.innerWidth <= 550) {
    isSearchActive = false;
    search.style.cssText = `display: none;`;
  } else {
    isSearchActive = true;
    search.style.cssText = `display: block;`;
  }
});

function bodyActive() {
  if (window.innerWidth < 550) {
    const search = document.querySelector(".search-header");
    isSearchActive = false;
    search.style.cssText = `display: none;`;
  }

  const settings = document.querySelector("#settings-content");
  if (settings.style.display == "block") settings.style.display = "none";
}

const seacrhInput = document.querySelector(".search-header");
seacrhInput.addEventListener("click", (e) => {
  e.stopPropagation();
});

const searchButton = document.querySelector("#searchActive");
searchButton.addEventListener("click", (e) => {
  searchActive(e);
});

function searchActive(e) {
  e.stopPropagation();
  if (window.innerWidth < 550) {
    isSearchActive = !isSearchActive;
    const search = document.querySelector(".search-header");
    if (isSearchActive) {
      search.style.cssText = `display: block; position: absolute; width: 40%; margin-right: 1rem;`;
    } else {
      search.style.cssText = `display: none;`;
    }
  }
}

const settingsButton = document.querySelector("#drop-settings");
settingsButton.addEventListener("click", (e) => {
  e.stopPropagation();
  const settings = document.querySelector("#settings-content");
  if (settings.style.display == "none" || settings.style.display == "") {
    settings.style.display = "block";
  } else {
    settings.style.display = "none";
  }
});

const searchByName = document.querySelector(".seacrh_by_name");
searchByName.addEventListener("click", async (e) => {
  e.stopPropagation();
  const seacrhInput = document.querySelector(".search-header");
  const searchValue = seacrhInput.value;
  // console.log(searchValue);

  window.location.href = `/search_posts/?=${searchValue}?=name`;
});

const searchByViews = document.querySelector(".seacrh_by_views");
searchByViews.addEventListener("click", async (e) => {
  e.stopPropagation();
  const seacrhInput = document.querySelector(".search-header");
  const searchValue = seacrhInput.value;
  // console.log(searchValue);

  window.location.href = `/search_posts/?=${searchValue}?=viewed`;
});

const searchByDate = document.querySelector(".seacrh_by_date");
searchByDate.addEventListener("click", async (e) => {
  e.stopPropagation();
  const seacrhInput = document.querySelector(".search-header");
  const searchValue = seacrhInput.value;
  // console.log(searchValue);

  window.location.href = `/search_posts/?=${searchValue}?=created_at`;
});
