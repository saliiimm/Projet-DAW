<?php 
//on inclut le fichier qui fera connecter cette page à noter bdd:
include('./config/bd_connect.php');

?>




<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Ajouter une ville</title>
    <style>
    label {
        display: block;
        margin-bottom: 10px;
    }

    select,
    input[type="text"] {
        width: 300px;
        margin-bottom: 10px;
    }

    #nouveauContinent,
    #nouveauPays {
        display: none;
    }

    #listeHotels,
    #listeGares,
    #listeAeroports,
    #listePhotos {
        width: 300px;
        height: 100px;
        margin-bottom: 10px;
    }

    #listeHotels option,
    #listeGares option,
    #listeAeroports option,
    #listePhotos option {
        margin-bottom: 5px;
    }
    </style>
</head>

<body>
    <h1>Ajouter une ville</h1>
    <form method="POST" action="ajout.php">


        <label for="ville">Ville :</label>
        <input type="text" name="ville" value="<?php echo htmlspecialchars($ville) ?>" required>
        <!---afficher valeur insérée avant si elle existe--->
        <br>
        <div class=""><?php echo $errors['ville'] ?></div>
        <!---afficher erreur si elle existe--->


        <label for="continent">Continent :</label>
        <select id="continent" name="continent" required>
            <option value="">Sélectionnez un continent</option>
            <!-- Code PHP pour charger les continents -->
            <?php
        $continents = array("Europe", "Amérique", "Asie", "Afrique", "Océanie");
        foreach ($continents as $continent) {
          echo "<option value=\"$continent\">$continent</option>";
        }
      ?>
        </select>
        <button type="button" id="nouveauContinentBtn">Nouveau</button>
        <br>

        <label for="pays">Pays :</label>
        <select id="pays" name="pays" required>
            <option value="">Sélectionnez un pays</option>
            <!-- Code PHP pour charger les pays -->
            <?php
        $pays = array("France", "États-Unis", "Chine", "Algérie", "Australie");
        foreach ($pays as $pays) {
          echo "<option value=\"$pays\">$pays</option>";
        }
      ?>
        </select>
        <button type="button" id="nouveauPaysBtn">Nouveau</button>
        <br>

        <h2>Hôtels :</h2>
        <input type="text" id="hotel" name="hotels" placeholder="Nom de l'hôtel">
        <button type="button" onclick="ajouterElement('hotel')">Ajouter</button>
        <br>
        <select id="listeHotels" multiple></select>

        <h2>Gares :</h2>
        <input type="text" id="gare" name="gares" placeholder="Nom de la gare">
        <button type="button" onclick="ajouterElement('gare')">Ajouter</button>
        <br>
        <select id="listeGares" multiple></select>

        <h2>Aéroports :</h2>
        <input type="text" id="aeroport" name="aeroports" placeholder="Nom de l'aéroport">
        <button type="button" onclick="ajouterElement('aeroport')">Ajouter</button>
        <br>
        <select id="listeAeroports" multiple></select>

        <h2>Photos :</h2>
        <input type="text" id="photo" name="photos" placeholder="Chemin de la photo">
        <button type="button" onclick="ajouterElement('photo')">Ajouter</button>
        <br>
        <select id="listePhotos" multiple></select>

        <br><br>
        <button type="submit">Ajouter</button>
    </form>

    <script>
    function ajouterElement(element) {
        var input = document.getElementById(element);
        var liste = document.getElementById("liste" + element + "s");

        if (input.value !== '') {
            var option = document.createElement("option");
            option.text = input.value;
            liste.add(option);
            input.value = '';
        }
    }

    var nouveauContinentBtn = document.getElementById("nouveauContinentBtn");
    var nouveauPaysBtn = document.getElementById("nouveauPaysBtn");
    var nouveauContinent = document.getElementById("nouveauContinent");
    var nouveauPays = document.getElementById("nouveauPays");

    nouveauContinentBtn.addEventListener("click", function() {
        nouveauContinent.style.display = "block";
    });

    nouveauPaysBtn.addEventListener("click", function() {
        nouveauPays.style.display = "block";
    });
    </script>
</body>

</html>