// Login functions

function navBurgerMain()
{
  let elementburger = document.getElementById("burgerMain");
  elementburger.classList.toggle("is-active");
  let elementnavbar = document.getElementById("navbarMain");
  elementnavbar.classList.toggle("is-active");
}

function loginModal() 
{
  let element = document.getElementById("login-modal");
  element.classList.toggle("is-active");
  document.getElementById("loginUsername").focus();
}

function signUpModal() 
{
  let element = document.getElementById("user_modal");
  element.classList.toggle("is-active");
}

