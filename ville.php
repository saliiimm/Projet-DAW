<?php

// on inclut le fichier qui fera connecter cette page à notre bdd :
include('config/bd_connect.php');
//on se connecte à notre base de donnée en insérant le host,le nom d'utilisateur le mot de passe ainsi que le nom de notre databse dans cet ordre
$conn = mysqli_connect('localhost','Salim&Ramzy','1234','voyage');

//Par la suite on verifie si l'on s'est bien connecté à la DB:
if(!$conn){
    echo 'connection error: ' . mysqli_connect_error();
}    


// Récupérer l'identifiant de la ville depuis l'URL
if (isset($_GET['id'])) {
    $idVille = $_GET['id'];

// Effectuer une requête pour récupérer les informations de la ville spécifiée
$sql = "SELECT ville.nomvil, pays.nompay, continent.nomcon, ville.descvil, gare.nomnec AS gare, hotel.nomnec AS hotel, aeroport.nomnec AS aeroport, site.cheminphoto
        FROM ville
        INNER JOIN necessaire AS gare ON ville.idvil = gare.idvil AND gare.typenec = 'gare'
        INNER JOIN necessaire AS hotel ON ville.idvil = hotel.idvil AND hotel.typenec = 'hotel'
        INNER JOIN necessaire AS aeroport ON ville.idvil = aeroport.idvil AND aeroport.typenec = 'aeroport'
        INNER JOIN pays ON ville.idpay = pays.idpay
        INNER JOIN continent ON pays.idcon = continent.idcon
        LEFT JOIN site ON ville.idvil = site.idvil
        WHERE ville.idvil = $idVille";

$result = mysqli_query($conn, $sql);

// Vérifier si la requête a renvoyé des résultats
if (mysqli_num_rows($result) > 0) {
    $ville = mysqli_fetch_assoc($result);
    $cheminphoto = $ville['cheminphoto'];
} else {
    echo "Ville non trouvée.";
}

// Fermer le résultat de la requête
mysqli_free_result($result);

// Requête pour récupérer la liste des hôtels de la ville
$sqlHotels = "SELECT nomnec FROM necessaire WHERE idvil = $idVille AND typenec = 'hotel'";
$resultHotels = mysqli_query($conn, $sqlHotels);
$hotels = mysqli_fetch_all($resultHotels, MYSQLI_ASSOC);

// Requête pour récupérer la liste des restaurants de la ville
$sqlRestaurants = "SELECT nomnec FROM necessaire WHERE idvil = $idVille AND typenec = 'restaurant'";
$resultRestaurants = mysqli_query($conn, $sqlRestaurants);
$restaurants = mysqli_fetch_all($resultRestaurants, MYSQLI_ASSOC);

// Requête pour récupérer la liste des gares de la ville
$sqlGares = "SELECT nomnec FROM necessaire WHERE idvil = $idVille AND typenec = 'gare'";
$resultGares = mysqli_query($conn, $sqlGares);
$gares = mysqli_fetch_all($resultGares, MYSQLI_ASSOC);

// Requête pour récupérer la liste des aéroports de la ville
$sqlAeroports = "SELECT nomnec FROM necessaire WHERE idvil = $idVille AND typenec = 'aeroport'";
$resultAeroports = mysqli_query($conn, $sqlAeroports);
$aeroports = mysqli_fetch_all($resultAeroports, MYSQLI_ASSOC);

} else {
    echo "ID de ville non spécifié.";
    exit();
}

// Fermer la connexion à la base de données
mysqli_close($conn);

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Accueil</title>
    <link rel="stylesheet" href="cssjs/style.css" />
    <link href="//db.onlinewebfonts.com/c/35c8dd5006b186a4bcfaebc6670f805f?family=Skyfont" rel="stylesheet"
        type="text/css" />
</head>

<body>
    <!--- On fait appel à header.php pour afficher le header --->
    <?php include('./templates/header.php'); ?>

    <section class="ville-info">
        <div class="partie1">
            <h2 class="gras">Vous avez choisi</h2>
            <h1><?php echo htmlspecialchars($ville['nomvil']); ?></h1>
            <p>Découvrez quelques informations sur cette ville</p>
            <hr>
        </div>
        <div class="partie2">
            <div class="principales">
                <div>
                    <h5 class="gras">Nom de la ville</h5>
                    <h5><?php echo htmlspecialchars($ville['nomvil']); ?></h5>
                </div>
                <div>
                    <h5 class="gras">Pays</h5>
                    <h5><?php echo htmlspecialchars($ville['nompay']); ?></h5>
                </div>
                <div>
                    <h5 class="gras">Continent</h5>
                    <h5><?php echo htmlspecialchars($ville['nomcon']); ?></h5>
                </div>
            </div>
            <div class="details">
                <h3 class="gras">Description</h3>
                <p><?php echo htmlspecialchars($ville['descvil']); ?></p>
                <h3 class="gras">Sites</h3>

                <h4 class="gras">Photos :</h4>
                <div class="diaporama">


                    <div class="site-photos">
                        <button class="prev-button">Précédent</button>
                        <?php if ($cheminphoto) : ?>
                        <?php $photos = explode(",", $cheminphoto); ?>
                        <?php foreach ($photos as $photo) : ?>
                        <div class="site-photo">
                            <img src="<?php echo htmlspecialchars($photo); ?>" alt="Site photo">
                        </div>
                        <?php endforeach; ?>
                        <?php else : ?>
                        <p>Aucune photo disponible.</p>
                        <?php endif; ?>

                        <button class="next-button">Suivant</button>
                    </div>



                </div>
            </div>
            <div class="transport">
                <div class="hotelsville">
                    <h4 class="gras">Hôtels :</h4>
                    <ul>
                        <?php foreach ($hotels as $hotel) : ?>
                        <li><?php echo htmlspecialchars($hotel['nomnec']); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="restaurantsville">
                    <h4 class="gras">Restaurants :</h4>
                    <ul>
                        <?php foreach ($restaurants as $restaurant) : ?>
                        <li><?php echo htmlspecialchars($restaurant['nomnec']); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="garesville">
                    <h4 class="gras">Gares :</h4>
                    <ul>
                        <?php foreach ($gares as $gare) : ?>
                        <li><?php echo htmlspecialchars($gare['nomnec']); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="aeroportsville">
                    <h4 class="gras">Aéroports :</h4>
                    <ul>
                        <?php foreach ($aeroports as $aeroport) : ?>
                        <li><?php echo htmlspecialchars($aeroport['nomnec']); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
        </div>
    </section>
    <?php include('./templates/footer.php'); ?>
    <script src="/cssjs/index.js"></script>
</body>

</html>