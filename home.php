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
                  WHERE continent.nomcon like '%$continent%'";
    }

    if (!empty($pays)) {
        $sql .= " AND pays.nompay like '%$pays%'";
    }


     if (!empty($ville)) {
        $sql .= " AND ville.nomvil like '%$ville%'";
    }

    if (!empty($site)) {
       $sql .= " INNER JOIN site ON ville.idvil = site.idvil
              WHERE site.nomsit LIKE '%$site%'";
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



// Suppression d'une ville
if (isset($_POST['delete'])) {
    $id = mysqli_real_escape_string($conn, $_POST['delete']);

       // Suppression des nécessaires en rapport avec la ville
    $sql = "DELETE FROM necessaire WHERE idvil = $id";
    mysqli_query($conn, $sql);

    // Suppression des sites en rapport avec la ville
    $sql = "DELETE FROM site WHERE idvil = $id";
    mysqli_query($conn, $sql);

    // Suppression de la ville
    $sql = "DELETE FROM ville WHERE idvil = $id";
    mysqli_query($conn, $sql);

    if (mysqli_query($conn, $sql)) {
        // La suppression a réussi, rediriger vers la page d'accueil
        header('Location: home.php');
    } else {
        // En cas d'erreur, afficher un message d'erreur
        echo 'Erreur de suppression : ' . mysqli_error($conn);
    }
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
                        <input type="text" name="continent"
                            value="<?php echo isset($continent) ? htmlspecialchars($continent) : ''; ?>">
                    </div>
                    <div>
                        <label for="pays">Pays</label>
                        <input type="text" name="pays"
                            value="<?php echo isset($pays) ? htmlspecialchars($pays) : ''; ?>">
                    </div>
                </div>
                <div class="part">
                    <div>
                        <label for="ville">Ville</label>
                        <input type="text" name="ville"
                            value="<?php echo isset($ville) ? htmlspecialchars($ville) : ''; ?>">
                    </div>
                    <div>
                        <label for="site">Site</label>
                        <input type="text" name="site"
                            value="<?php echo isset($site) ? htmlspecialchars($site) : ''; ?>">
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
                            <form method="POST" class="delete-form">
                                <input type="hidden" name="delete" value="<?php echo $ville['idvil']; ?>">
                                <button type="submit" class="delete-btn"><img src="./assets/supprimer-btn.png"
                                        alt="supprimer-btn"></button>
                            </form>
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

    <img src="./assets/valise.png" alt="valise-de-voyage" class="valise">

    <script src="cssjs/index.js"></script>
</body>

</html>