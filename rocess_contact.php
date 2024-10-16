<?php
// Initialisation des variables pour le traitement
$message = ""; // Pour stocker le message de succès ou d'erreur

// Vérifie si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Récupère les données du formulaire
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $messageText = $_POST['message'];

    // Prépare et exécute la requête pour insérer les données
    $sql = "INSERT INTO contacts (name, email, subject, message) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $email, $subject, $messageText);

    // Exécute la requête et vérifie le succès
    if ($stmt->execute()) {
        $message = "Merci, votre message a été envoyé avec succès.";
    } else {
        $message = "Une erreur est survenue. Veuillez réessayer.";
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
    <title>Contact Form</title>
    <script>
        // Fonction pour afficher une alerte si un message est présent
        function showMessage(message) {
            if (message) {
                alert(message);
            }
        }
    </script>
</head>
<body onload="showMessage('<?php echo addslashes($message); ?>')">
    <form action="" method="POST">
        <div class="row g-3">
            <div class="col-md-6">
                <div class="form-floating">
                    <input type="text" class="form-control" name="name" id="name" placeholder="Your Name" required>
                    <label for="name">Your Name</label>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-floating">
                    <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
                    <label for="email">Your Email</label>
                </div>
            </div>

            <div class="col-12">
                <div class="form-floating">
                    <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required>
                    <label for="subject">Subject</label>
                </div>
            </div>

            <div class="col-12">
                <div class="form-floating">
                    <textarea class="form-control" name="message" placeholder="Leave a message here" id="message" style="height: 150px" required></textarea>
                    <label for="message">Message</label>
                </div>
            </div>

            <div class="col-12">
                <button class="btn btn-primary w-100 py-3" type="submit">Send Message</button>
            </div>
        </div>
    </form>
</body>
</html>
