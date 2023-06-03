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

var nouveauContinentBtn = document.getElementById("nouveauContinentBtn");
var nouveauPaysBtn = document.getElementById("nouveauPaysBtn");
var nouveauContinent = document.getElementById("nouveauContinent");
var nouveauPays = document.getElementById("nouveauPays");

nouveauContinentBtn.addEventListener("click", function () {
  nouveauContinent.style.display = "block";
});

nouveauPaysBtn.addEventListener("click", function () {
  nouveauPays.style.display = "block";
});
