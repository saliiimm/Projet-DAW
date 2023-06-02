<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Récupérer les données du formulaire
  $nom = $_POST['nom'];
  $population = $_POST['population'];
  $pays = $_POST['pays'];

  // Vérifier si les champs obligatoires sont remplis
  if (!empty($nom) && !empty($population) && !empty($pays)) {
    // Connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password = "1234";
    $dbname = "voyage";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
      die("Erreur de connexion à la base de données : " . $conn->connect_error);
    }

    // Préparer et exécuter la requête d'insertion
    $sql = "INSERT INTO villes (nom, population, pays) VALUES ('$nom', $population, '$pays')";
    if ($conn->query($sql) === TRUE) {
      echo "La ville a été ajoutée avec succès.";
    } else {
      echo "Erreur lors de l'ajout de la ville : " . $conn->error;
    }

    // Fermer la connexion à la base de données
    $conn->close();
  } else {
    echo "Veuillez remplir tous les champs obligatoires.";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Ajouter une ville</title>
</head>
<body>
  <h1>Ajouter une ville</h1>
  <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label for="nom">Nom :</label>
    <input type="text" id="nom" name="nom" required><br>

    <label for="population">Population :</label>
    <input type="number" id="population" name="population" required><br>

    <label for="pays">Pays :</label>
    <input type="text" id="pays" name="pays" required><br>

    <input type="submit" value="Ajouter">
  </form>
</body>
</html>
