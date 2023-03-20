// Js modal / Popup ------------------

const modal = document.querySelector(".mod");
const modal_container = document.querySelector(".modal_container");
const exit = document.querySelector(".close_mod");

if (modal) {
  modal.addEventListener("click", () => {
    modal_container.classList.toggle("active");
    modal.style.display = "none";
  });
}

exit.addEventListener("click", () => {
  modal_container.classList.toggle("active");
  modal.style.display = "block";
});

// Search Article
// affichage de la recherche

const addSearch = document.getElementById("search");

if (addSearch) {
  addSearch.addEventListener("keyup", () => {
    setTimeout(() => {
      const results = document.querySelector(".resultarticle");
      if (results) {
        results.style.display = "flex";
      }
    }, 400);
  });
}
// display none de la div resultat si on clic a coter

const body = document.querySelector("body");
const results = document.querySelector(".resultarticle");

if (results) {
  if (addSearch.value.length == 0) {
    results.style.display = "none";
  }
  body.addEventListener("click", (e) => {
    if (!e.target.closest(".resultarticle")) {
      results.style.display = "none";
    }
  });
}

// Scroll button ----------------------------------------
// New Release

const buttonRight = document.getElementById("slideright");

if (buttonRight) {
  buttonRight.onclick = () => {
    document.getElementById("new").scrollLeft += 350;
  };
  const buttonLeft = document.getElementById("sliderleft");

  buttonLeft.onclick = () => {
    document.getElementById("new").scrollLeft -= 350;
  };
}

// Top tpics

const buttonRightLike = document.getElementById("sliderightLike");

if (buttonRightLike) {
  buttonRightLike.onclick = () => {
    document.getElementById("top").scrollLeft += 350;
  };
  const buttonLeftLike = document.getElementById("sliderleftLike");

  buttonLeftLike.onclick = () => {
    document.getElementById("top").scrollLeft -= 350;
  };
}

// Button Voir Plus

const contents = document.querySelectorAll(".contenupanel");

const morecontent = document.querySelectorAll("#morecontent");
if (morecontent) {
    for (let i = 0; i < morecontent.length; i++) {
      morecontent[i].addEventListener("click", () => {
        contents[i].style.height = "100px";
        console.log(morecontent[i]);
        morecontent[i].textContent = " Voir moins";
      });
    }
}
