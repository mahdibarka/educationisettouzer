<?php
// newsletter_signup.php

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

$message = ""; // Variable pour stocker le message

// Vérifie si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Prépare et exécute la requête pour insérer l'email
    $sql = "INSERT INTO emails (email) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);

    // Exécute la requête et vérifie le succès
    if ($stmt->execute()) {
        $message = "Merci ! Votre email a été enregistré avec succès.";
    } else {
        // Affiche un message d'erreur si l'email est déjà enregistré
        if ($conn->errno == 1062) {
            $message = "Cet email est déjà inscrit à notre newsletter.";
        } else {
            $message = "Une erreur est survenue. Veuillez réessayer plus tard.";
        }
    }

    // Ferme la requête et la connexion
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Newsletter Signup</title>
    <script>
        // Fonction pour afficher une alerte si un message de succès est présent
        function showMessage(message) {
            if (message) {
                alert(message);
            }
        }
    </script>
</head>
<body onload="showMessage('<?php echo $message; ?>')">
    <form action="newsletter_signup.php" method="post">
        <div class="position-relative mx-auto" style="max-width: 400px;">
            <input class="form-control border-0 w-100 py-3 ps-4 pe-5" type="email" name="email" placeholder="Your email" required>
            <button type="submit" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">SignUp</button>
        </div>
    </form>
</body>
</html>
