
// Login functions

function navBurgerMain()
{
  var elementburger = document.getElementById("burgerMain");
  elementburger.classList.toggle("is-active");
  var elementnavbar = document.getElementById("navbarMain");
  elementnavbar.classList.toggle("is-active");
}

function loginModal() 
{
  var element = document.getElementById("login-modal");
  element.classList.toggle("is-active");
}

function signUpModal() 
{
  var element = document.getElementById("user_modal");
  element.classList.toggle("is-active");
}
