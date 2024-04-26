<?php

    class Admin {
        private int $adminId = 0;

        private string $pseudo = "";

        private string $email = "";

        private string $password = "";
    
        public function getId(){return $this->adminId;}
        public function setId($adminId){$this->adminId = $adminId;}
    
        public function getPseudo(){return $this->pseudo;}
        public function setPseudo($pseudo){$this->pseudo = $pseudo;}
    
        public function getEmail(){return $this->email;}
        public function setEmail($email){$this->email = $email;}
    
        public function getPassword(){return $this->password;}
        public function setPassword($password){$this->password = $password;}

    public function checkAdmin($pseudo ,$email, $password) {

    require_once __DIR__ ."../../config/config.php";

    $dsn = "mysql:host=" . HOST . ";";
    $dsn .= "port=" . PORT . ";";
    $dsn .= "dbname=" . DBNAME . ";";
    $dsn .= "charset=" . CHARSET . ";";


        if($_SERVER["REQUEST_METHOD"] == "POST") {
            // Données postées depuis un formulaire
            $username = $_POST["pseudo"];
            $email = $_POST["email"];
            $password = $_POST["password"];

            try {
            
                //Connexion à la base de donnée
                $connexion = new PDO ($dsn, DBUSER, DBPASS);
                $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
                $sql = "SELECT * FROM admin WHERE pseudo=:pseudo AND email=:email AND password=:password ;";
                // Préparation de la requête
                $requete = $connexion-> prepare($sql);
                $requete->bindParam(":pseudo", $pseudo);
                $requete->bindParam(":email", $email);
                $requete->bindParam(":password", $password);
            
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

    