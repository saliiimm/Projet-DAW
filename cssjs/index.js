function ajouterElement(element) {
  var input = document.getElementById(element);
  var liste = document.getElementById("liste" + element + "s");

  if (input.value !== "") {
    var option = document.createElement("option");
    option.text = input.value;
    liste.add(option);
    input.value = "";
  }
}

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
  matricule.innerText = "212000000000";
  email.innerText = "ramzybelaiboud@gmail.com";
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
  groupe.innerText = "4";
  bnt2.style.filter = "brightness(1.75)";
  bnt1.style.filter = "brightness(0.75)";
  console.log("coucou");
});
console.log("coucou");
document.addEventListener("DOMContentLoaded", function () {
  //pop up
  // Get the modal
  var modal = document.getElementById("myModal");

  // Get the button that opens the modal
  var suppBtn = document.querySelectorAll(".supprimer-btn");

  // Get the <span> element that closes the modal
  var span = document.querySelector(".close-modal");

  // When the user clicks on the button, open the modal
  for (let i = 0; i < suppBtn.length; i++)
    suppBtn[i].addEventListener("click", () => {
      modal.style.display = "block";
      console.log("ca marche");
    });

  // When the user clicks on <span> (x), close the modal
  span.onclick = function () {
    modal.style.display = "none";
  };

  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function (event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  };
});

//ajouter dans listes:(ajout.php)
//hotels:
document.getElementById("addHotel").addEventListener("click", function () {
  const inputHotel = document.getElementById("inputHotel").value;

  if (inputHotel !== "") {
    const option = document.createElement("option");
    option.value = inputHotel;
    option.text = inputHotel;
    document.getElementById("selectHotel").appendChild(option);
    document.getElementById("inputHotel").value = "";
  }
});

//gares:
document.getElementById("addGare").addEventListener("click", function () {
  const inputGare = document.getElementById("inputGare").value;

  if (inputGare !== "") {
    const option = document.createElement("option");
    option.value = inputGare;
    option.text = inputGare;
    document.getElementById("selectGare").appendChild(option);
    document.getElementById("inputGare").value = "";
  }
});

//aeroports:
document.getElementById("addAeroport").addEventListener("click", function () {
  const inputAeroport = document.getElementById("inputAeroport").value;

  if (inputAeroport !== "") {
    const option = document.createElement("option");
    option.value = inputAeroport;
    option.text = inputAeroport;
    document.getElementById("selectAeroport").appendChild(option);
    document.getElementById("inputAeroport").value = "";
  }
});

//liens images:
document.getElementById("addPhoto").addEventListener("click", function () {
  const inputPhoto = document.getElementById("inputPhoto").value;

  if (inputPhoto !== "") {
    const option = document.createElement("option");
    option.value = inputPhoto;
    option.text = inputPhoto;
    document.getElementById("selectPhoto").appendChild(option);
    document.getElementById("inputPhoto").value = "";
  }
});

//envoyer les listes aux bdds:
// Récupérer les valeurs sélectionnées dans les listes
var gareList = document.getElementById("gareList").value;
var hotelList = document.getElementById("hotelList").value;
var aeroportList = document.getElementById("aeroportList").value;

// Créer un objet FormData et y ajouter les valeurs
var formData = new FormData();
formData.append("gareList", gareList);
formData.append("hotelList", hotelList);
formData.append("aeroportList", aeroportList);

// Envoyer les données via une requête AJAX
var xhr = new XMLHttpRequest();
xhr.open("POST", "ajout.php", true);
xhr.onreadystatechange = function () {
  if (xhr.readyState === 4 && xhr.status === 200) {
    // Traitement de la réponse du serveur
    console.log(xhr.responseText);
  }
};
xhr.send(formData);
