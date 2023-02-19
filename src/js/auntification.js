let isAuntificationActive = true;

const show_pswd = document.querySelector(".show_pswd");
show_pswd.addEventListener("click", (e) => {
  e.stopPropagation();
  const pswd = document.querySelector(".form:not(.hidden) .pswd");
  if (pswd.type == "password") {
    pswd.type = "text";
  } else {
    pswd.type = "password";
  }
});

const registration = document.querySelector("#registration");

registration.addEventListener("click", (e) => {
  e.stopPropagation();
  const reg_form = document.querySelector(".reg_form");
  const auth_form = document.querySelector(".auth_form");
  if (reg_form.classList.contains("hidden")) {
    registration.textContent = "Войти";
    reg_form.classList.remove("hidden");
    auth_form.classList.add("hidden");
  } else
  {
    registration.textContent = "Зарегистрироваться";
    reg_form.classList.add("hidden");
    auth_form.classList.remove("hidden");
  }
});