<?php

require_once __DIR__. ('../../Utiltary/Log.php');

class Category {
    private int $categoryId = 0;
    private string $name = "";

        public function getId(){return $this->categoryId;}
        public function setId($categoryId){$this->categoryId = $categoryId;}
    
        public function getName(){return $this->name;}
        public function setName($name){$this->name = $name;}

        public function findOneCategoryById() {
            include_once __DIR__ . "../../config/config.php";
        
            $sql = "SELECT * FROM category WHERE category_id = :categoryId";
        
            try {
                $db = new PDO("mysql:host=" . Database::HOST . "; port=" . Database::PORT . "; dbname=" . Database::DBNAME . "; charset=utf8;", Database::DBUSER, Database::DBPASS);
        
                $req = $db->prepare($sql);
                $req->bindParam(":categoryId", $this->categoryId, PDO::PARAM_INT);
        
                $req->execute();
        
                // Récupérez le résultat de la requête
                $result = $req->fetch(PDO::FETCH_ASSOC);
        
                // Si aucun résultat n'est trouvé, renvoyez null
                if (!$result) {
                    return null;
                }
        
                // Sinon, renvoyez le résultat
                return $result;
            } catch (Exception | Error $ex) {
                echo $ex->getMessage();
            }
        }
        public static function findAllCategories(): array {
            include_once __DIR__ . "../../config/config.php";
    
            $sql = "SELECT category_id, name FROM category";
    
            try {
                $db = new PDO("mysql:host=" . Database::HOST . "; port=" . Database::PORT . "; dbname=" . Database::DBNAME . "; charset=utf8;", Database::DBUSER, Database::DBPASS);
    
                $req = $db->prepare($sql);
                if ($req->execute()) {
                // La requête s'est bien passée !
    
                    $results = $req->fetchAll(PDO::FETCH_ASSOC);
    
                    return $results;
                } else {
                // La requête n'a pu être executée
                    return array();
                }
            } catch (Exception | Error $ex) {
                echo $ex->getMessage();
                return array();
            }
        }

}