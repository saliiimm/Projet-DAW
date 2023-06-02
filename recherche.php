<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "voyage";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Échec de la connexion à la base de données: " . $conn->connect_error);
}

// Récupération des critères de recherche
$continent = $_POST['continent'];
$pays = $_POST['pays'];
$ville = $_POST['ville'];

// Construction de la requête SQL
$sql = "SELECT ville.idvil, ville.nomvil, pays.nompay FROM ville 
        INNER JOIN pays ON ville.idpay = pays.idpay 
        INNER JOIN continent ON pays.idcon = continent.idcon
        WHERE continent.nomcon LIKE '%$continent%'
        AND pays.nompay LIKE '%$pays%'
        AND ville.nomvil LIKE '%$ville%'";

// Exécution de la requête SQL
$result = $conn->query($sql);

// Affichage des résultats
if ($result->num_rows > 0) {
    echo "<ul>";
    while ($row = $result->fetch_assoc()) {
        echo "<li><a href=\"villes.php?id=".$row['idvil']."\">".$row['nomvil']." (".$row['nompay'].")</a></li>";
    }
    echo "</ul>";
} else {
    echo "Aucun résultat trouvé.";
}

$conn->close();
?>
