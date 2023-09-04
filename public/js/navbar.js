const menuBtn = document.querySelector(".menu-button");
const navbarToggle = document.querySelector(".navbar-toggle");
const overlay = document.querySelector(".overlay");
const chevron = document.querySelector(".fa-solid.fa-chevron-down");

const menuBtnResponsive = document.querySelector(".menu-button-responsive");
const navbarToggleResponsive = document.querySelector(
   ".navbar-toggle-responsive"
);

menuBtn?.addEventListener("click", (e) => {
   e.stopPropagation();

   navbarToggle?.classList.toggle("invisible");
   chevron.classList.toggle("rotate");
});

document.body.addEventListener("click", (e) => {
   navbarToggle?.classList.add("invisible");
   chevron.classList.remove("rotate");
});

window.addEventListener("resize", () => {
   navbarToggle?.classList.add("invisible");
   chevron.classList.remove("rotate");
});

menuBtnResponsive?.addEventListener("click", (e) => {
   e.stopPropagation();

   navbarToggleResponsive?.classList.toggle("invisible");
   chevron.classList.toggle("rotate");
});

document.body.addEventListener("click", (e) => {
   navbarToggleResponsive?.classList.add("invisible");
   chevron.classList.remove("rotate");
});

window.addEventListener("resize", () => {
   navbarToggleResponsive?.classList.add("invisible");
   chevron.classList.remove("rotate");
});
