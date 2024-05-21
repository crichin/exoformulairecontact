<?php
// Initialisation des variables
$nom = $prenom = $pays = $telephone = $email = $message = '';
$nom_err = $prenom_err = $pays_err = $telephone_err = $email_err = $message_err = '';

// Vérification si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérification du champ Nom
    if (empty($_POST["nom"])) {
        $nom_err = "Veuillez entrer votre nom.";
    } else {
        $nom = trim($_POST["nom"]);
        if (!preg_match("/^[a-zA-Z ]{3,}$/", $nom)) {
            $nom_err = "Le nom doit comporter au moins 3 lettres alphabétiques.";
        }
    }

    // Vérification du champ Prénom
    if (empty($_POST["prenom"])) {
        $prenom_err = "Veuillez entrer votre prénom.";
    } else {
        $prenom = trim($_POST["prenom"]);
        if (!preg_match("/^[a-zA-Z ]{3,}$/", $prenom)) {
            $prenom_err = "Le prénom doit comporter au moins 3 lettres alphabétiques.";
        }
    }

    // Vérification du champ Pays
    if (empty($_POST["pays"])) {
        $pays_err = "Veuillez entrer votre pays.";
    } else {
        $pays = trim($_POST["pays"]);
    }

    // Vérification du champ Téléphone
    if (empty($_POST["telephone"])) {
        $telephone_err = "Veuillez entrer votre numéro de téléphone.";
    } else {
        $telephone = trim($_POST["telephone"]);
        if (!preg_match("/^\+?(\d[\s-]?)?(\(\d{1,3}\)[\s-]?)?[\d\s-]{5,15}$/", $telephone)) {
            $telephone_err = "Format de numéro de téléphone invalide.";
        }
    }

    // Vérification du champ Email
    if (empty($_POST["email"])) {
        $email_err = "Veuillez entrer votre adresse email.";
    } else {
        $email = trim($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_err = "Format d'email invalide.";
        }
    }

    // Vérification du champ Message
    if (empty($_POST["message"])) {
        $message_err = "Veuillez entrer votre message.";
    } else {
        $message = trim($_POST["message"]);
    }

    // Si aucune erreur de validation, insérer les données dans la base de données
    if (empty($nom_err) && empty($prenom_err) && empty($pays_err) && empty($telephone_err) && empty($email_err) && empty($message_err)) {
        include("db.php");

        // Requête préparée pour insérer les données
        $requete = $bdd->prepare("INSERT INTO contactme (nom, prenom, pays, telephone, email, message) VALUES (?, ?, ?, ?, ?, ?)");

        // Liaison des paramètres
        $requete->bindParam(1, $nom);
        $requete->bindParam(2, $prenom);
        $requete->bindParam(3, $pays);
        $requete->bindParam(4, $telephone);
        $requete->bindParam(5, $email);
        $requete->bindParam(6, $message);

        // Exécution de la requête
        if ($requete->execute()) {
            // Succès : rediriger vers une page de confirmation
            header("Location: confirm.php");
            exit();
        } else {
            // Erreur lors de l'exécution de la requête
            echo "Erreur lors de l'enregistrement des données dans la base de données.";
        }
    }
}
?>







<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Formulaire de Contact</title>
</head>
<body>
    <div class="container">
        <h2>Formulaire de Contact</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="contact-form">
            <div class="form-group">
                <label for="nom">Nom:</label><br>
                <input type="text" id="nom" name="nom" class="input-field" value="<?php echo htmlspecialchars($nom); ?>" required>
                <span class="error"><?php echo $nom_err; ?></span><br>
            </div>

            <div class="form-group">
                <label for="prenom">Prénom:</label><br>
                <input type="text" id="prenom" name="prenom" class="input-field" value="<?php echo htmlspecialchars($prenom); ?>" required>
                <span class="error"><?php echo $prenom_err; ?></span><br>
            </div>

            <div class="form-group">
                <label for="pays">Pays:</label><br>
                <input type="text" id="pays" name="pays" class="input-field" value="<?php echo htmlspecialchars($pays); ?>" required>
                <span class="error"><?php echo $pays_err; ?></span><br>
            </div>

            <div class="form-group">
                <label for="telephone">Téléphone:</label><br>
                <input type="text" id="telephone" name="telephone" class="input-field" value="<?php echo htmlspecialchars($telephone); ?>" required>
                <span class="error"><?php echo $telephone_err; ?></span><br>
            </div>

            <div class="form-group">
                <label for="email">Email:</label><br>
                <input type="email" id="email" name="email" class="input-field" value="<?php echo htmlspecialchars($email); ?>" required>
                <span class="error"><?php echo $email_err; ?></span><br>
            </div>

            <div class="form-group">
                <label for="message">Message:</label><br>
                <textarea id="message" name="message" rows="4" class="input-field" required><?php echo htmlspecialchars($message); ?></textarea>
                <span class="error"><?php echo $message_err; ?></span><br>
            </div>

            <input type="submit" value="Envoyer" class="submit-btn">
        </form>
    </div>
</body>
</html>
