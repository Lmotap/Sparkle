<?php

require_once __DIR__ . ('../../../App/Utiltary/Log.php');

session_name("admin");
session_start();


    if($_SERVER["REQUEST_METHOD"] == "POST") {

        $username = $_POST["pseudo"];
        $email = $_POST["email"];
        $password = $_POST["password"];

        //Connexion à la base de donnée
        $connexion = new PDO ("mysql:host=localhost; dbname=blog_portfolio", "lmotap", "Te9B1cp!L3aV+iD!");
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT * FROM admin WHERE pseudo=:pseudo AND email=:email;";

        $requete = $connexion-> prepare($sql);
        $requete->bindParam(":pseudo", $username); 
        $requete->bindParam(":email", $email); 

        if ($requete-> execute()) {
            $resultat = $requete->fetch();
            var_dump($resultat);

            if (!empty($resultat)) {
                
                if (password_verify($password, $resultat["password"] )) {
            
                        $_SESSION['admin'] = [
                        'admin_id' => $resultat['admin_id'],
                        'pseudo' => $resultat['pseudo'],
                        'email' => $resultat['email']
                    ];

                    
                    $_SESSION['adminId'] = $resultat['admin_id'];

                    header('Location: dashboard.php');
                    exit();
                } else {
                    
                    echo "Identifiants incorrects";
                }
            } else {
                
                echo "Identifiants incorrects";
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire Admin</title>

        <!-- Favicon -->
        <link rel="shortcut icon" href="/assets/img/favicon.ico" type="image/x-icon">

        <!-- CSS !-->
        <link rel="stylesheet" href="../../assets/styles/reset.css">
        <link rel="stylesheet" href="../../assets/styles/layout.css">
        <link rel="stylesheet" href="../../assets/styles/style.css">

</head>
<body>
    <div class="container-logo">
        <a href="/index.html"><img id="logo-img" src="../../assets/img/logo_black.png" alt="Logo du projet"></a>
    </div>

    <h2 class="title_admin">Admin formulaire</h2>

    <div class="container_form_admin">
        <form action="#" method="post">

                <label for="pseudo">Pseudo</label>
                <input type="text" name="pseudo" id="pseudo" autocomplete="pseudo" placeholder="Pseudo" aria-label="your pseudo" required />

                <label for="email">Email</label>
                <input type="email" name="email" id="email" autocomplete="email" placeholder="Email" aria-label="your email" required />

                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" autocomplete="password" placeholder="Mot de passe" aria-label="your password" required />
            
                <button class="btn_submit" type="submit" aria-label="send"> Se connecter !</button>
            
        </form>
    </div>

</body>
</html>