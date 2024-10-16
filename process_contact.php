<?php
// process_contact.php

// Connexion à la base de données
$servername = "localhost";
$username = "root"; // Remplace avec ton nom d'utilisateur MySQL
$password = ""; // Remplace avec ton mot de passe MySQL
$dbname = "universitaireDB"; // Utiliser la base de données universitaireDB

// Crée la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifie la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

// Vérifie si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupère les données du formulaire
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Prépare et exécute la requête pour insérer les données
    $sql = "INSERT INTO contacts (name, email, subject, message) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $email, $subject, $message);

    // Exécute la requête et vérifie le succès
    if ($stmt->execute()) {
        echo "<script>alert('Merci, votre message a été envoyé avec succès.'); window.location.href='contact_form.html';</script>";
    } else {
        echo "<script>alert('Une erreur est survenue. Veuillez réessayer.'); window.location.href='contact_form.html';</script>";
    }

    // Ferme la requête et la connexion
    $stmt->close();
    $conn->close();
} else {
    echo "Méthode de requête non autorisée.";
}
?>
