// Js modal / Popup ------------------

const modal = document.querySelector(".mod");
const modal_container = document.querySelector(".modal_container");
const exit = document.querySelector(".close_mod");

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

// Scroll button ----------------------------------------
// New Release 

const buttonRight = document.getElementById("slideright");

buttonRight.onclick = () => {
  document.getElementById("new").scrollLeft += 300;
};
const buttonLeft = document.getElementById("sliderleft");

buttonLeft.onclick = () => {
  document.getElementById("new").scrollLeft -= 300;
};

// Top tpics

const buttonRightLike = document.getElementById("sliderightLike");

buttonRightLike.onclick = () => {
  document.getElementById("top").scrollLeft += 300;
};
const buttonLeftLike = document.getElementById("sliderleftLike");

buttonLeftLike.onclick = () => {
  document.getElementById("top").scrollLeft -= 300;
};