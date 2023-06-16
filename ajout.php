<?php 
//on inclut le fichier qui fera connecter cette page à noter bdd:
//include('/config/bd_connect.php');

//on se connecte à notre base de donnée en insérant le host,le nom d'utilisateur le mot de passe ainsi que le nom de notre databse dans cet ordre
$conn = mysqli_connect('localhost','Salim&Ramzy','1234','voyage');

//Par la suite on verifie si l'on s'est bien connecté à la DB:
if(!$conn){
    echo 'connection error: ' . mysqli_connect_error();
}    




//on initialise nos vars dabs lesquels on recupere les données de l'utilisateur:
$ville = $description = $continent = $pays = $hotel = $gare = $aeroport = $nomsit = $photo = '';



//on fait un tableau dans lequel on stocke les erreurs si existantes:
$errors = array('ville' => '','description' => '','continent' => '','pays' => '','hotel' => '','gare' => '','aeroport' => '','nomsit' => '','photo' => '');



//ici on va verifier apres un click sur submit si les valeurs ont bien été tous insérés et avec le bon format pour chacun:

if(isset($_POST['submit'])){
    
$gareList = $_POST['gareList'];
$hotelList = $_POST['hotelList'];
$aeroportList = $_POST['aeroportList'];

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
        $description = html_entity_decode($description);
        if(!preg_match('/^[\p{L}0-9\s.,\'’\-!?"()]+$/u', $description)){
            $errors['description']="Veuillez insérer une description valide! ";
        }
    }

    

//On verifie le continent:
    if(empty($_POST['continent'])){
  
        $errors['continent']="Veuillez choisir un continent! ";
    } else {
        $continent = trim(htmlspecialchars($_POST['continent']));
        if($continent!= 'Europe' && $continent!= 'Amérique' && $continent!= 'Asie' && $continent!= 'Afrique' && $continent!= 'Océanie' ){
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
        if(!preg_match('/^[a-zA-Z\s.,\'-]+$/', $hotel)){
            $errors['hotel']="Veuillez insérer ou choisir un hotel valide! ";
        }
    }



    //On verifie la gare:
    if(empty($_POST['gare'])){
  
        $errors['gare']="Veuillez insérer une gare! ";
    } else {
        $gare = htmlspecialchars($_POST['gare']);
        if(!preg_match('/^[a-zA-Z\s.,\'-]+$/', $gare)){
            $errors['gare']="Veuillez insérer ou choisir une gare valide! ";
        }
    }



    //On verifie l'aeroport:
    if(empty($_POST['aeroport'])){
  
        $errors['aeroport']="Veuillez insérer une gare! ";
    } else {
        $aeroport = htmlspecialchars($_POST['aeroport']);
        if(!preg_match('/^[a-zA-Z\s.,\'-]+$/', $aeroport)){
            $errors['aeroport']="Veuillez insérer ou choisir un aeroport valide! ";
        }
    }



    //On verifie le site touristique:
    if(empty($_POST['nomsit'])){
  
        $errors['nomsit']="Veuillez insérer un nom de site touristique valide! ";
    } else {
        $nomsit = htmlspecialchars($_POST['nomsit']);
        if(!preg_match('/^[\p{L}0-9\s.,\'’\-!?"()]+$/u', $nomsit)){
            $errors['nomsit']="Veuillez insérer un nom de site touristique valide! ";
        }
    }



    //On verifie le lien de la photo:
    if(empty($_POST['photo'])){
  
        $errors['photo']="Veuillez insérer une photo! ";
    } else {
        $photo = htmlspecialchars($_POST['photo']);
     /*   if(!preg_match('#\b(https?://\S+\.(?:png|jpe?g|gif)\S*)\b#i', $photo)){
           $errors['photo']="Veuillez insérer ou choisir une photo avec un format valide! ";*/
        }
    



//Maintenant on récupére les valeurs insérés s'il y a pas d'erreurs:
if(array_filter($errors)){
    //Si c'est le cas, on renvoi les erreurs
}else {
//pas d'erreurs
$ville = mysqli_real_escape_string($conn,$_POST['ville']);
$description = mysqli_real_escape_string($conn,$_POST['description']);
$continent = mysqli_real_escape_string($conn,$_POST['continent']);
$pays = mysqli_real_escape_string($conn,$_POST['pays']);
$gare = mysqli_real_escape_string($conn,$_POST['gare']);
$hotel = mysqli_real_escape_string($conn,$_POST['hotel']);
$aeroport = mysqli_real_escape_string($conn,$_POST['aeroport']);
$nomsit = mysqli_real_escape_string($conn,$_POST['nomsit']);
$photo = mysqli_real_escape_string($conn,$_POST['photo']);



//donner les commmandes sql pour inserer nos valeurs dans notre bdd:


// Vérification de l'existence du pays
$sql1 = "SELECT idpay FROM pays WHERE nompay = '$pays' AND idcon = (SELECT idcon FROM continent WHERE nomcon = '$continent')";
$result = mysqli_query($conn, $sql1);

if (mysqli_num_rows($result) > 0) {
  // Le pays existe déjà, récupérer l'ID
  $row = mysqli_fetch_assoc($result);
  $idpay = $row['idpay'];
} else {
  // Le pays n'existe pas, l'insérer dans la base de données
  $sql1 = "INSERT INTO pays (nompay, idcon) VALUES ('$pays', (SELECT idcon FROM continent WHERE nomcon = '$continent'))";
  mysqli_query($conn, $sql1);
  $idpay = mysqli_insert_id($conn);
}

// Insérer la ville
$sql2 = "INSERT INTO ville (nomvil, descvil, idpay) SELECT '$ville', '$description', pays.idpay FROM pays JOIN continent ON pays.idcon = continent.idcon WHERE pays.nompay = '$pays' AND continent.nomcon = '$continent'";
mysqli_query($conn, $sql2);
$idvil = mysqli_insert_id($conn);

// Insérer les éléments nécessaires (gare, hôtel, aéroport)
if (!empty($gareList)) {
  foreach ($gareList as $gare) {
    $sql3 = "INSERT INTO necessaire (typenec, nomnec, idvil) SELECT 'gare', '$gare', '$idvil' FROM dual";
    mysqli_query($conn, $sql3);
  }
} else {
  // Si la liste est vide, insérer l'élément de l'input
  $sql3 = "INSERT INTO necessaire (typenec, nomnec, idvil) SELECT 'gare', '$gare', '$idvil' FROM dual";
  mysqli_query($conn, $sql3);
}

if (!empty($hotelList)) {
  foreach ($hotelList as $hotel) {
    $sql4 = "INSERT INTO necessaire (typenec, nomnec, idvil) SELECT 'hotel', '$hotel', '$idvil' FROM dual";
    mysqli_query($conn, $sql4);
  }
} else {
  // Si la liste est vide, insérer l'élément de l'input
  $sql4 = "INSERT INTO necessaire (typenec, nomnec, idvil) SELECT 'hotel', '$hotel', '$idvil' FROM dual";
  mysqli_query($conn, $sql4);
}

if (!empty($aeroportList)) {
  foreach ($aeroportList as $aeroport) {
    $sql5 = "INSERT INTO necessaire (typenec, nomnec, idvil) SELECT 'aeroport', '$aeroport', '$idvil' FROM dual";
    mysqli_query($conn, $sql5);
  }
} else {
  // Si la liste est vide, insérer l'élément de l'input
  $sql5 = "INSERT INTO necessaire (typenec, nomnec, idvil) SELECT 'aeroport', '$aeroport', '$idvil' FROM dual";
  mysqli_query($conn, $sql5);
}

// Insérer le site avec sa photo (à partir de l'input)
if (!empty($nomsit) && !empty($photo)) {
  $sql6 = "INSERT INTO site (nomsit, cheminphoto, idvil) SELECT '$nomsit', '$photo', '$idvil' FROM dual";
  mysqli_query($conn, $sql6);
}



//sauvegarder dans la bdd et verifier:
if(mysqli_query($conn, $sql1) && mysqli_query($conn, $sql2) && mysqli_query($conn, $sql3) && mysqli_query($conn, $sql4) && mysqli_query($conn, $sql5) && mysqli_query($conn, $sql6)){
 //   echo "données enregistrées!";
 header('location: home.php');/*si pas d'erreurs après submit aller vers autre page*/
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ajouter une ville</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <!---on fait appel a header.php pour faire afficher le header--->
    <?php include('./templates/header.php'); ?>
    <section class="ajout-ville">
        <form method="POST" action="ajout.php">
            <h1>Ajouter une ville</h1>
            <div class="ajout-groupe">
                <div>
                    <label for="ville">Ville :</label>
                    <input type="text" name="ville" value="<?php echo htmlspecialchars($ville) ?>" required>
                    <!---afficher valeur insérée avant si elle existe--->
                    <br>
                    <div><?php echo $errors['ville'] ?></div>
                    <!---afficher erreur si elle existe--->
                </div>


                <div>
                    <label for="description">Description :</label>
                    <input type="text" name="description" value="<?php echo htmlspecialchars($description) ?>" required>
                    <!---afficher valeur insérée avant si elle existe--->
                    <br>
                    <div><?php echo $errors['description'] ?></div>

                </div>
            </div>








            <div class="ajout-groupe">
                <div>
                    <label for="continent">Continent :</label>
                    <div class="aligner">
                        <select id="continent" name="continent" required>
                            <option value="<?php echo htmlspecialchars($continent) ?>">Sélectionnez un continent
                            </option>
                            <!-- Code PHP pour charger les continents -->
                            <?php
        $continents = array("Europe", "Amérique", "Asie", "Afrique", "Océanie");
        foreach ($continents as $continent) {
          echo "<option value=\"$continent\">$continent</option>";
        }
      ?>
                        </select>
                        <button type="button" class="btnplus" id="nouveauContinentBtn"> <span>+</span> </button>
                    </div>

                    <br>
                    <div><?php echo $errors['continent'] ?></div>


                </div>








                <div>
                    <label for="pays">Pays :</label>
                    <div class="aligner">
                        <select id="pays" name="pays" value="<?php echo htmlspecialchars($pays) ?>" required>
                            <option value="">Sélectionnez un pays</option>
                            <!-- Code PHP pour charger les pays -->
                            <?php
    // Connectez-vous à votre base de données ici

    // Exécutez la requête pour récupérer les pays
    $query = "SELECT nompay FROM pays";
    $result = mysqli_query($conn, $query);

    // Parcourez les résultats et affichez les options du menu déroulant
    while ($row = mysqli_fetch_assoc($result)) {
        $pays = $row['nompay'];
        echo "<option value=\"$pays\">$pays</option>";
    }

    // Fermez la connexion à la base de données ici

    ?>
                        </select>
                        <button type="button" class="btnplus" id="nouveauPaysBtn"><span>+</span></button>
                    </div>

                    <br>
                    <div><?php echo $errors['pays'] ?></div>

                </div>
            </div>
















            <div class="ajout-groupe">
                <div>
                    <h2>Hôtels :</h2>
                    <div class="aligner">
                        <input type="text" id="inputHotel" name="hotel" placeholder="Nom de l'hôtel"
                            value="<?php echo htmlspecialchars($hotel) ?>">
                        <button type="button" class="btn-ajouter" id="addHotel">Ajouter</button>
                    </div>

                    <br>
                    <select id="selectHotel" multiple></select>
                    <div><?php echo $errors['hotel'] ?></div>

                </div>




                <div>
                    <h2>Gares :</h2>
                    <div class="aligner">
                        <input type="text" id="inputGare" name="gare" placeholder="Nom de la gare"
                            value="<?php echo htmlspecialchars($gare) ?>">
                        <button type="button" class="btn-ajouter" id="addGare">Ajouter</button>
                    </div>

                    <br>
                    <select id="selectGare" multiple></select>
                    <div><?php echo $errors['gare'] ?></div>

                </div>

            </div>






            <div class="ajout-groupe">
                <div>
                    <h2>Aéroports :</h2>
                    <div class="aligner">
                        <input type="text" id="inputAeroport" name="aeroport" placeholder="Nom de l'aéroport"
                            value="<?php echo htmlspecialchars($aeroport) ?>">
                        <button type="button" class="btn-ajouter" id="addAeroport">Ajouter</button>
                    </div>

                    <br>
                    <select id="selectAeroport" multiple></select>
                    <div><?php echo $errors['gare'] ?></div>

                </div>




                <div>
                    <label for="nomsit">Site Touristique:</label>
                    <input type="text" name="nomsit" value="<?php echo htmlspecialchars($nomsit) ?>" required>
                    <!---afficher valeur insérée avant si elle existe--->
                    <br>
                    <div><?php echo $errors['nomsit'] ?></div>
                </div>
            </div>



            <div class="ajout-groupe">
                <div>
                    <h2>Photos :</h2>
                    <div class="aligner"> <input type="text" id="inputPhoto" name="photo"
                            placeholder="Chemin de la photo" value="<?php echo htmlspecialchars($photo) ?>">
                        <button type="button" class="btn-ajouter" id="addPhoto">Ajouter</button>
                    </div>

                    <br>
                    <select id="selectPhoto" multiple></select>
                    <div><?php echo $errors['photo'] ?></div>
                </div>
            </div>



            <button type="submit" value="submit" name=submit>Ajouter</button>

        </form>
    </section>

    <img src="./assets/carte-monde.png" alt="carte-du-monde" class="carte">
    <script src="cssjs/index.js"></script>
</body>

</html>