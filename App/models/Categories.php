<?php

require_once __DIR__. ('../../Utiltary/Log.php');


class Category {
    private int $categoryId = 0;
    private string $name = "";

        public function getId(){return $this->categoryId;}
        public function setId($categoryId){$this->categoryId = $categoryId;}
    
        public function getPseudo(){return $this->name;}
        public function setPseudo($name){$this->name = $name;}

        public function findOneCategoryById() {
            include_once __DIR__ . "../../config/config.php";
    
            $sql = "SELECT * FROM category WHERE categoryId = :categoryId";
    
            try {
                $db = new PDO("mysql:host=" . Database::HOST . "; port=" . Database::PORT . "; dbname=" . Database::DBNAME . "; charset=utf8;", Database::DBUSER, Database::DBPASS);
    
                $req->bindParam("categoryId, $this->categoryId", PDO::PARAM_INT);
                $req = $db->prepare($sql);
    
                $req->execute();
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