<?php

require_once __DIR__. ('../../Utiltary/Log.php');

class Media {
    private int $media_id = 0;
    private ?string $url = "";
    private int $article = 0;

    
    public function getId(){return $this->media_id;}
    public function setId($media_id){$this->media_id = $media_id;}

    public function getURL(){return $this->url;}
    public function setURL($url){$this->url = $url;}

    public function getArticleId(){return $this->article;}
    public function setArticleId($article){$this->article = $article;}


    public function __construct($media_id, $url, $article) {
        $this->media_id = $media_id;
        $this->url = $url;
        $this->article = $article;
    }

    public function createMedia(): bool {
        include_once __DIR__ . "../../config/config.php";
    
        $sqlInsert = "INSERT INTO media (url, article) VALUES (:url, :article);";
    
        try {
            $db = new PDO("mysql:host=" . Database::HOST . "; port=" . Database::PORT . "; dbname=" . Database::DBNAME . "; charset=utf8;", Database::DBUSER, Database::DBPASS);
        
            $reqInsert = $db->prepare($sqlInsert);
            $reqInsert->bindParam(":url", $this->url, PDO::PARAM_STR);
            $reqInsert->bindParam(":article", $this->article, PDO::PARAM_INT);
            
            // Insérez ces commandes ici
            if ($reqInsert->execute()) {
                $this->media_id = $db->lastInsertId();
                return true;
            } else {
                return false;
            }
            

        } catch (Exception | Error $ex) {
            echo $ex->getMessage();
            return false;
        }
    }

    public function updateMedia(): bool {
        include_once __DIR__ . "../../config/config.php";
    
        $sqlUpdate = "UPDATE media SET url = :url, article = :article WHERE media_id = :media_id;";
    
        try {
            $db = new PDO("mysql:host=" . Database::HOST . "; port=" . Database::PORT . "; dbname=" . Database::DBNAME . "; charset=utf8;", Database::DBUSER, Database::DBPASS);
        
            $reqUpdate = $db->prepare($sqlUpdate);
            $reqUpdate->bindParam(":url", $this->url, PDO::PARAM_STR);
            $reqUpdate->bindParam(":article", $this->article, PDO::PARAM_INT);
            $reqUpdate->bindParam(":media_id", $this->media_id, PDO::PARAM_INT);
            
            // Insérez ces commandes ici
            if ($reqUpdate->execute()) {
                return true;
            } else {
                return false;
            }
            

        } catch (Exception | Error $ex) {
            echo $ex->getMessage();
            return false;
        }
    }

    

    public function readMedia(): array {
        include_once __DIR__ . "../../config/config.php";
    
        $sqlRead = "SELECT * FROM media WHERE media_id = :media_id;";
    
        try {
            $db = new PDO("mysql:host=" . Database::HOST . "; port=" . Database::PORT . "; dbname=" . Database::DBNAME . "; charset=utf8;", Database::DBUSER, Database::DBPASS);
        
            $reqRead = $db->prepare($sqlRead);
            $reqRead->bindParam(":media_id", $this->media_id, PDO::PARAM_INT);
            
            // Insérez ces commandes ici
            if ($reqRead->execute()) {
                $result = $reqRead->fetch(PDO::FETCH_ASSOC);
                return $result;
            } else {
                return array();
            }
            

        } catch (Exception | Error $ex) {
            echo $ex->getMessage();
            return array();
        }
    }

    
}