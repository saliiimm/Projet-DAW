<?php 
//on inclut le fichier qui fera connecter cette page à noter bdd:
//include('/config/bd_connect.php');

//on se connecte à notre base de donnée en insérant le host,le nom d'utilisateur le mot de passe ainsi que le nom de notre databse dans cet ordre
$conn = mysqli_connect('localhost','Salim&Ramzy','1234','voyage');

//Par la suite on verifie si l'on s'est bien connecté à la DB:
if(!$conn){
    echo 'connection error: ' . mysqli_connect_error();
}   


// Vérifier si le formulaire de recherche a été soumis
if (isset($_POST['submit'])) {
    // Récupérer les valeurs des champs de recherche
    $continent = $_POST['continent'];
    $pays = $_POST['pays'];
    $ville = $_POST['ville'];
    $site = $_POST['site'];

    // Construire la requête SQL de recherche en fonction des champs remplis
$sql = "SELECT ville.idvil, ville.nomvil, pays.nompay FROM ville
        INNER JOIN pays ON ville.idpay = pays.idpay";


    // Ajouter les conditions de recherche en fonction des champs remplis
    if (!empty($continent)) {
        $sql .= " INNER JOIN continent ON pays.idcon = continent.idcon
                  WHERE continent.nomcon = '$continent'";
    }

    if (!empty($pays)) {
        $sql .= " AND pays.nompay = '$pays'";
    }


     if (!empty($ville)) {
        $sql .= " AND ville.nomvil = '$ville'";
    }

    if (!empty($site)) {
        $sql .= " AND site.nomsit = '$site'";
    }

    // Exécuter la requête SQL
    $result = mysqli_query($conn, $sql);

 // Vérifier si la requête a renvoyé des résultats
    if (mysqli_num_rows($result) > 0) {
        // Récupérer les résultats sous forme de tableau associatif
        $villes = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        // Aucune ville trouvée
        $villes = [];
    }
    //avoir les resultats comme array
   // $villes = mysqli_fetch_all($result,MYSQLI_ASSOC);

    // Libérer la mémoire du résultat
    mysqli_free_result($result);
}

// Fermer la connexion à la base de données
mysqli_close($conn);





?>









<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Acceuil</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <!---on fait appel a header.php pour faire afficher le header--->
    <?php include('./templates/header.php'); ?>
    <section class="partie-home">
        <div class="recherche-bloc">
            <h2>Dites nous ou vous voulez aller !</h2>
            <form action="home.php" method="POST">
                <div class="part">
                    <div>
                        <label for="continent">Continent</label>
                        <input type="text" name="continent">
                    </div>
                    <div>
                        <label for="pays">Pays</label>
                        <input type="text" name="pays">
                    </div>
                </div>
                <div class="part">
                    <div>
                        <label for="ville">Ville</label>
                        <input type="text" name="ville">
                    </div>
                    <div>
                        <label for="site">Site</label>
                        <input type="text" name="site">
                    </div>
                </div>
                <button type="submit" value="submit" name=submit>Rechercher</button>

            </form>
        </div>
        <div class="resultat">
            <div class="affichage">
                <h2>Villes trouvées</h2>
                <div class="affichage-ville">
                    <?php if (!empty($villes)): ?>
                    <?php foreach($villes as $ville): ?>
                    <div class="ville">
                        <div class="ecriture">
                            <h3> <a
                                    href="ville.php?id=<?php echo $ville['idvil']  ?> "><?php echo htmlspecialchars($ville['nomvil']); ?></a>
                            </h3>
                            <hr>
                            <h5><?php echo htmlspecialchars($ville['nompay']); ?></h5>
                        </div>
                        <div class="icones">
                            <img src="./assets/btn-modifier.png" alt="modifier-btn">
                            <img src="./assets/supprimer-btn.png" alt="supprimer-btn">
                        </div>
                    </div>
                    <?php  endforeach; ?>
                    <?php else: ?>
                    <p>Aucune ville trouvée.</p>
                    <?php endif; ?>
                </div>

            </div>


        </div>
    </section>


    <script src="./cssjs/index.js"></script>
</body>

</html>