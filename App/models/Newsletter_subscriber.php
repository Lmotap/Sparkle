<?php

    class Admin {
        private int $newsletterSubscriberId = 0;
        private string $email = "";

        public function getId(){return $this->newsletterSubscriberId;}
        public function setId($newsletterSubscriberId){$this->newsletterSubscriberId = $newsletterSubscriberId;}
    
        public function getPseudo(){return $this->email;}
        public function setPseudo($email){$this->email = $email;}

    public function createSubscriber($email) {

    require_once __DIR__ ."../../config/config.php";

    $dsn = "mysql:host=" . HOST . ";";
    $dsn .= "port=" . PORT . ";";
    $dsn .= "dbname=" . DBNAME . ";";
    $dsn .= "charset=" . CHARSET . ";";


        if($_SERVER["REQUEST_METHOD"] == "POST") {
            // Données postées depuis un formulaire
            $email = $_POST["email"];

            try {
            
                //Connexion à la base de donnée
                $connexion = new PDO ($dsn, DBUSER, DBPASS);
                $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
                $sql = "INSERT INTO newsletter_subscriber
                (email)
                VALUES
                (:email);";
                // Préparation de la requête
                $requete = $connexion-> prepare($sql);
                $requete->bindParam(":email", $email);
            
                if ($requete-> execute()) {
                    $resultat = $requete->fetch();
                    var_dump($resultat);
                } 
            } catch (Exception|Error $exc) {
                Log::log($exc);
                return false;
            }
        }
    }
}

    