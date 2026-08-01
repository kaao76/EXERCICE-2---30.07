<?php
$connexion = new mysqli("localhost", "root", "", "bdd_php_EX2");

if ($connexion->connect_error) {
    die("Erreur de connexion : " . $connexion->connect_error);
} else {
    echo "Connexion réussie !<br>";
}

$sql_creation = "CREATE TABLE IF NOT EXISTS utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    prenom VARCHAR(100),
    annee_naissance INT,
    email VARCHAR(100) UNIQUE
)";

if ($connexion->query($sql_creation) === TRUE) {
    echo "Table prête !<br>";
} else {
    echo "Erreur création : " . $connexion->error . "<br>";
}

$nom = "Dupont";
$prenom = "Marie";
$annee_naissance = 1998;
$email = "marie.dupont@example.com";

$sql_insert = "INSERT INTO utilisateurs (nom, prenom, annee_naissance, email) VALUES (?, ?, ?, ?)";
$stmt = $connexion->prepare($sql_insert);
$stmt->bind_param("ssis", $nom, $prenom, $annee_naissance, $email);

if ($stmt->execute()) {
    $age = date("Y") - $annee_naissance;
    echo "Utilisateur ajouté ! Âge : " . $age . " ans.";
} else {
    if ($connexion->errno === 1062) {
        echo "Erreur : cet email existe déjà (doit être unique).";
    } else {
        echo "Erreur ajout : " . $stmt->error;
    }
}

$stmt->close();
$connexion->close();
?>