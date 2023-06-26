<?php
include('config/bd_connect.php');

// Vérifier si les données ont été soumises via la méthode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les valeurs du formulaire
    $idVille = $_POST["idVille"];
    $nomVille = $_POST["nomVille"];
    $descVille = $_POST["descVille"];
    $pays = $_POST["pays"];
    $sites = $_POST["sites"];
    $hotel = $_POST["hotel"];
    $resto = $_POST["resto"];
    $gare = $_POST["gare"];
    $aeroport = $_POST["aeroport"];
    $image=$_POST["image"];
    
    
    // Vérifier si une image a été téléchargée
   

    // Insérer les données dans la base de données
    $sql2 = "SELECT idpay FROM pays WHERE nompay='$pays'";
    $result = mysqli_query($conn, $sql2);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $idpays = $row['idpay'];

        // Effectuer la mise à jour dans la base de données
        $sqlUpdate = "UPDATE ville SET nomvil = '$nomVille', descvil = '$descVille', idpay = $idpays WHERE idvil= $idVille;";
        if (mysqli_query($conn, $sqlUpdate)) {
            // Supprimer les anciens enregistrements de sites pour cette ville
            mysqli_query($conn, "DELETE FROM site WHERE idvil = $idVille");
            mysqli_query($conn, "DELETE FROM necessaire WHERE idvil = $idVille");

            // Insérer le nouveau site avec l'image
            mysqli_query($conn, "INSERT INTO site (idvil, nomsit, cheminphoto) VALUES ($idVille, '$sites', '$image')");
            mysqli_query($conn, "INSERT INTO necessaire (idvil, typenec, nomnec) VALUES ($idVille, 'restaurant', '$resto')");
            mysqli_query($conn, "INSERT INTO necessaire (idvil, typenec, nomnec) VALUES ($idVille, 'hotel', '$hotel')");
            mysqli_query($conn, "INSERT INTO necessaire (idvil, typenec, nomnec) VALUES ($idVille, 'gare', '$gare')");
            mysqli_query($conn, "INSERT INTO necessaire (idvil, typenec, nomnec) VALUES ($idVille, 'aeroport', '$aeroport')");
            
          

      


            echo "Mise à jour effectuée avec succès.";
        } else {
            echo "Erreur lors de la mise à jour : " . mysqli_error($conn);
        }
    } else {
        echo "Erreur lors de la récupération de l'ID du pays.";
    }

    // Redirection vers la page de détails de la ville modifiée ou vers la liste des villes
    header("Location: ville.php?id=$idVille");
    exit();
}

// Affichage du formulaire de modification
$idVille = isset($_GET['id']) ? $_GET['id'] : null;

if ($idVille): 
    $sql = "SELECT ville.*, pays.nompay AS nom_pays, site.*
    FROM ville
    JOIN pays ON ville.idpay = pays.idpay
    JOIN site ON ville.idvil = site.idvil
    WHERE ville.idvil= $idVille";
    $rslt = mysqli_query($conn, $sql);
    $ville = mysqli_fetch_assoc($rslt);
    mysqli_free_result($rslt);
    mysqli_close($conn);
    ?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Modifier</title>
    <link rel="stylesheet" href="cssjs/style.css" />
</head>


<body>
    <!---on fait appel a header.php pour faire afficher le header--->
    <?php include('./templates/header.php'); ?>
    <section class="partie-home">
        <h1>Modifier</h1>

        <?php if ($ville): ?>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data"
            class="modifier-form">
            <div class="part">
                <input type="hidden" name="idVille" value="<?php echo $ville['idvil']; ?>">
                <!-- nom ville -->

                <div><label for="nomVille">Nom :</label>
                    <input type="text" name="nomVille" value="<?php echo $ville['nomvil']; ?>">
                </div>
            </div>


            <div class="part">
                <div> <label for="descVille">descVille :</label>
                    <textarea name="descVille"><?php echo $ville['descvil']; ?></textarea>
                </div>
                <!-- pays -->
                <div> <label for="pays">Pays :</label>
                    <input type="text" name="pays" value="<?php echo $ville['nom_pays']; ?>">
                </div>
            </div>

            <div class="part">
                <div> <label for="sites">Sites :</label>
                    <input type="text" name="sites" value="<?php echo $ville['nomsit']; ?>">
                </div>
                <!--image site -->
                <div> <label for="sites">image site :</label>
                    <input type="text" name="image" id="image">
                </div>
            </div>

            <div class="part">
                <!-- Liste des hôtels -->
                <div>
                    <label for="hotel">Hotels:</label>
                    <input type="text" name="hotel" id="hotel" placeholder="Hotels" />
                </div>
                <!-- Liste des restaurants -->
                <div> <label for="resto">Restaurant:</label>
                    <input type="text" name="resto" id="restaurant" placeholder="Restaurants" />

                </div>

            </div>



            <div class="part">
                <!-- Liste des gares -->
                <div>
                    <label for="gare">Gares:</label>
                    <input type="text" name="gare" id="gare" placeholder="Gares" />


                </div>

                <!-- Liste des aéroports -->
                <div>
                    <label for="aeroport">Aeroport:</label>
                    <input type="text" name="aeroport" id="aeroport" placeholder="Aeroport" />


                </div>
            </div>



            <div>
                <input type="submit" value="Enregistrer" name="submit">
            </div>
        </form>
        <?php else: ?>
        <p>Ville non trouvée.</p>
        <?php endif; ?>
    </section>

    <?php include('./templates/footer.php'); ?>
    <script src="cssjs/index.js"></script>

</body>

</html>
<?php else: ?>
<p>Identifiant de ville non spécifié.</p>
<?php endif; ?>