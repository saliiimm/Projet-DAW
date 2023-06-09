let nom = document.querySelector(".nom");
let prenom = document.querySelector(".prenom");
let matricule = document.querySelector(".matricule");
let email = document.querySelector(".mail");
let groupe = document.querySelector(".groupe");

let bnt1 = document.querySelector(".btn1");
let bnt2 = document.querySelector(".btn2");

bnt1.addEventListener("click", () => {
  nom.innerText = "Belaiboud";
  prenom.innerText = "Ramzy";
  matricule.innerText = "212131086778";
  email.innerText = "ramzybelaiboud@gmail.com";
  email.href = "mailto:ramzybelaiboud@gmail.com";
  groupe.innerText = "6";
  console.log("bonjou");
  bnt1.style.filter = "brightness(1.75)";
  bnt2.style.filter = "brightness(0.75)";
});
bnt2.addEventListener("click", () => {
  nom.innerText = "Ghalem";
  prenom.innerText = "Salim";
  matricule.innerText = "212131095534";
  email.innerText = "salimghalem40@gmail.com";
  email.href = "mailto:salimghalem40@gmail.com";
  groupe.innerText = "4";
  bnt2.style.filter = "brightness(1.75)";
  bnt1.style.filter = "brightness(0.75)";
  console.log("coucou");
});
console.log("coucou");

//pop-up(modal) ajout pays:
const modalSection = document.getElementById("modalSection");
const showModal = () => {
  modalSection.style.display = "flex";
};

const hideModal = () => {
  modalSection.style.display = "none";
};

// Show the modal when needed (e.g., on button click)
const showButton = document.getElementById("nouveauPaysBtn");
showButton.addEventListener("click", showModal);

// Hide the modal when needed (e.g., on close button click)
const closeButton = document.getElementById("closeModalButton");
closeButton.addEventListener("click", hideModal);

//ajouter dans listes:(ajout.php)
function ajouter(element) {
  var input = document.getElementById(element);
  var liste = document.getElementById(element + "s");

  if (input.value !== "") {
    var option = document.createElement("option");
    option.text = input.value;
    liste.add(option);
    input.value = "";
  }
}

let i = 0;
function ajouter(event, parent, child) {
  event.preventDefault();

  const list = document.getElementById(parent);
  var input = document.getElementById(child);
  var text = input.value;

  var p = document.createElement("option");

  p.textContent = text;
  p.selected = true;
  p.addEventListener("dblclick", function () {
    list.removeChild(p);
  });
  list.appendChild(p);
  //list.insertBefore(p,list.firstElementChild);
}
// Fonction pour ajouter un site à la liste
function ajouterSite() {
  var nomsit = document.getElementById("nomsit").value;
  var photoInput = document.getElementById("photo");

  if (nomsit !== "" && photoInput.files.length > 0) {
    var reader = new FileReader();

    reader.onload = function (e) {
      var imageDataUrl = e.target.result;

      var site = {
        nomsit: nomsit,
        photo: imageDataUrl,
      };

      ajouterElementListe(site, "sites_list");
    };

    reader.readAsDataURL(photoInput.files[0]);
  }
}

// Fonction pour ajouter un élément à la liste
function ajouterElementListe(element, listeId) {
  var select = document.getElementById(listeId);

  var option = document.createElement("option");
  option.text = element.nomsit;
  option.value = element.photo;

  select.add(option);
}

//diaporama ville.php:
document.addEventListener("DOMContentLoaded", function () {
  const sitePhotos = document.querySelector(".site-photos");
  const prevButton = document.querySelector(".prev-button");
  const nextButton = document.querySelector(".next-button");

  let currentSlide = 0;

  function showSlide(index) {
    const slides = sitePhotos.querySelectorAll(".site-photo");
    if (index >= 0 && index < slides.length) {
      slides.forEach(function (slide) {
        slide.style.display = "none";
      });
      slides[index].style.display = "block";
      currentSlide = index;
    }
  }

  function prevSlide() {
    showSlide(currentSlide - 1);
  }

  function nextSlide() {
    showSlide(currentSlide + 1);
  }

  prevButton.addEventListener("click", prevSlide);
  nextButton.addEventListener("click", nextSlide);

  showSlide(0); // Afficher la première slide au chargement de la page
});

//modifier header selon la page dans laquelle nous sommes:

var btnHeader = document.querySelector(".btn-ville");
var currentURL = window.location.href;

if (currentURL.includes("ajout.php")) {
  btnHeader.href = "../projet-daw/home.php";
  btnHeader.textContent = "Accueil";
} else {
  btnHeader.href = "../projet-daw/ajout.php";
  btnHeader.textContent = "Ajouter une Ville";
}
