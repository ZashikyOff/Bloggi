// Js modal / Popup ------------------

const modal = document.querySelector(".mod");
const modal_container = document.querySelector(".modal_container");
const exit = document.querySelector(".close_mod");
console.log(modal);
console.log(modal_container);
console.log(exit);
if(modal){
  modal.addEventListener("click", () => {
    modal_container.classList.toggle("active");
    modal.style.display = "none";
  });
}

exit.addEventListener("click", () => {
  modal_container.classList.toggle("active");
  modal.style.display = "block";
});
