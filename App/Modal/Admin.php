<?php
    require_once "../config/config.php";
    class Admin {
        private int $id = 0;

        private string $pseudo = "";

        private string $email = "";

        private string $hash = "";
    

    /**We create function who intialize a value to a property in a objet, we can read this example like => 
     * Admin->$id = 2 */ 
    
    public function __set($property, $value) {
        $this->$property = $value;
    }

    /**We create function who geta property in a objet, we can read this example like => 
     * Admin->$id */ 
    public function __get($property) {
        return $this->$property;
    }

    public function checkAdmin($pseudo ,$email, $password) {
        $pdo = new PDO('mysql:host=' . HOST . ';port=' . PORT . ';dbname=' . DBNAME, DBUSER, DBPASS);
        $dsn = $pdo->prepare('SELECT * FROM admin WHERE email = :email');
        $dsn->execute(['email' => $email]);
        $admin = $dsn->fetch();

        if ($admin && password_verify($password, $admin['hash'])) {
            return $admin;
        }

        return false;
    }
}

    