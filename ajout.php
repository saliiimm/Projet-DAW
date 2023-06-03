<?php 
//on inclut le fichier qui fera connecter cette page à noter bdd:
include('./config/bd_connect.php');




//on initialise nos vars dabs lesquels on recupere les données de l'utilisateur:
$ville = $description = $continent = $pays = $hotel = $gare = $aeroport = $photo = '';

//on fait un tableau dans lequel on stocke les erreurs si existantes:
$errors = array('ville' => '','description' => '','continent' => '','pays' => '','hotel' => '','gare' => '','aeroport' => '','photo' => '');



//ici on va verifier apres un click sur submit si les valeurs ont bien été tous insérés et avec le bon format pour chacun:

if(isset($_POST['submit'])){



//On verifie la ville:
    if(empty($_POST['ville'])){
  
        $errors['ville']="Veuillez insérer une ville! ";
    } else {
        $ville = htmlspecialchars($_POST['ville']);
        if(!preg_match('/^[a-zA-Z\s]+$/', $ville)){
            $errors['ville']="Veuillez insérer une ville valide! ";
        }
    }



    //On verifie la description:
    if(empty($_POST['description'])){
  
        $errors['description']="Veuillez insérer une description! ";
    } else {
        $description = htmlspecialchars($_POST['description']);
        if(!preg_match('/^[a-zA-Z\s]+$/', $description)){
            $errors['description']="Veuillez insérer une description valide! ";
        }
    }

    

//On verifie le continent:
    if(empty($_POST['continent'])){
  
        $errors['continent']="Veuillez choisir un continent! ";
    } else {
        $continent = htmlspecialchars($_POST['continent']);
        if(!preg_match('/^[a-zA-Z\s]+$/', $continent)){
            $errors['continent']="Veuillez choisir un continent valide!";
        }
    }

    

//On verifie le pays:
    if(empty($_POST['pays'])){
  
        $errors['pays']="Veuillez insérer un pays! ";
    } else {
        $pays = htmlspecialchars($_POST['pays']);
        if(!preg_match('/^[a-zA-Z\s]+$/', $pays)){
            $errors['pays']="Veuillez insérer ou choisir un pays valide! ";
        }
    }



    //On verifie l'hotel:
    if(empty($_POST['hotel'])){
  
        $errors['hotel']="Veuillez insérer un hotel! ";
    } else {
        $hotel = htmlspecialchars($_POST['hotel']);
        if(!preg_match('/^[a-zA-Z\s]+$/', $hotel)){
            $errors['hotel']="Veuillez insérer ou choisir un hotel valide! ";
        }
    }



    //On verifie la gare:
    if(empty($_POST['gare'])){
  
        $errors['gare']="Veuillez insérer une gare! ";
    } else {
        $gare = htmlspecialchars($_POST['gare']);
        if(!preg_match('/^[a-zA-Z\s]+$/', $gare)){
            $errors['gare']="Veuillez insérer ou choisir une gare valide! ";
        }
    }



    //On verifie l'aeroport:
    if(empty($_POST['aeroport'])){
  
        $errors['aeroport']="Veuillez insérer une gare! ";
    } else {
        $aeroport = htmlspecialchars($_POST['aeroport']);
        if(!preg_match('/^[a-zA-Z\s]+$/', $aeroport)){
            $errors['aeroport']="Veuillez insérer ou choisir un aeroport valide! ";
        }
    }



    //On verifie la photo:
    if(empty($_POST['photo'])){
  
        $errors['photo']="Veuillez insérer une photo! ";
    } else {
        $photo = htmlspecialchars($_POST['photo']);
        if(!preg_match('/^[a-zA-Z\s]+$/', $photo)){
            $errors['photo']="Veuillez insérer ou choisir une photo avec un format valide! ";
        }
    }



//Maintenant on récupére les valeurs insérés s'il y a pas d'erreurs:
if(empty($errors)){
//pas d'erreurs
$ville = mysqli_real_escape_string($conn,$_POST['ville']);
$description = mysqli_real_escape_string($conn,$_POST['description']);
$continent = mysqli_real_escape_string($conn,$_POST['continent']);
$pays = mysqli_real_escape_string($conn,$_POST['pays']);
$gare = mysqli_real_escape_string($conn,$_POST['gare']);
$hotel = mysqli_real_escape_string($conn,$_POST['hotel']);
$aeroport = mysqli_real_escape_string($conn,$_POST['aeroport']);
$photo = mysqli_real_escape_string($conn,$_POST['photo']);



//donner les commmandes sql pour inserer nos valeurs dans notre bdd:



$sql = "INSERT INTO ville (nomvil) VALUES ('$ville');
        INSERT INTO pays (nompay) VALUES ('$pays')";


//sauvegarder dans la bdd et verifier:
if(mysqli_query($conn,$sql)){
 //   echo "données enregistrées!";
 header('location: recherche.php');/*si pas d'erreurs après submit aller vers autre page*/
}else {
     echo 'query error:' . mysqli_error($conn);
}

}

}//end POST


?>




<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Ajouter une ville</title>
    <link rel="stylesheet" href="./css_&_js/style.css" />
</head>
<!---on fait appel a header.php pour faire afficher le header--->
<?php include('./templates/header.php'); ?>
<h1>Ajouter une ville</h1>
<form method="POST" action="ajout.php">


    <label for="ville">Ville :</label>
    <input type="text" name="ville" value="<?php echo htmlspecialchars($ville) ?>" required>
    <!---afficher valeur insérée avant si elle existe--->
    <br>
    <div class=""><?php echo $errors['ville'] ?></div>
    <!---afficher erreur si elle existe--->


    <label for="description">Description :</label>
    <input type="text" name="description" value="<?php echo htmlspecialchars($description) ?>" required>
    <!---afficher valeur insérée avant si elle existe--->
    <br>
    <div class=""><?php echo $errors['description'] ?></div>


    <label for="continent">Continent :</label>
    <select id="continent" name="continent" required>
        <option value="<?php echo htmlspecialchars($continent) ?>">Sélectionnez un continent</option>
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
    <div class=""><?php echo $errors['continent'] ?></div>



    <label for="pays">Pays :</label>
    <select id="pays" name="pays" required>
        <option value="<?php echo htmlspecialchars($pays) ?>">Sélectionnez un pays</option>
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
    <div class=""><?php echo $errors['pays'] ?></div>



    <h2>Hôtels :</h2>
    <input type="text" id="hotel" name="hotels" placeholder="Nom de l'hôtel"
        value="<?php echo htmlspecialchars($hotel) ?>">
    <button type="button" onclick="ajouterElement('hotel')">Ajouter</button>
    <br>
    <select id="listeHotels" multiple></select>
    <div class=""><?php echo $errors['hotel'] ?></div>



    <h2>Gares :</h2>
    <input type="text" id="gare" name="gares" placeholder="Nom de la gare"
        value="<?php echo htmlspecialchars($gare) ?>">
    <button type="button" onclick="ajouterElement('gare')">Ajouter</button>
    <br>
    <select id="listeGares" multiple></select>
    <div class=""><?php echo $errors['gare'] ?></div>




    <h2>Aéroports :</h2>
    <input type="text" id="aeroport" name="aeroports" placeholder="Nom de l'aéroport"
        value="<?php echo htmlspecialchars($aeroport) ?>">
    <button type="button" onclick="ajouterElement('aeroport')">Ajouter</button>
    <br>
    <select id="listeAeroports" multiple></select>
    <div class=""><?php echo $errors['gare'] ?></div>




    <h2>Photos :</h2>
    <input type="text" id="photo" name="photos" placeholder="Chemin de la photo"
        value="<?php echo htmlspecialchars($photo) ?>">
    <button type="button" onclick="ajouterElement('photo')">Ajouter</button>
    <br>
    <select id="listePhotos" multiple></select>
    <div class=""><?php echo $errors['photo'] ?></div>
    <br><br>
    <button type="submit" value="submit">Ajouter</button>

</form>
<script src="./css_&_js/index.js"></script>
</body>

</html>