<?php

class Media {
    private ?int $media_id = 0;
    private ?string $url = "";
    private int $article = 0;

    
    public function getMediaId(){return $this->media_id;}
    public function setMediaId($media_id){$this->media_id = $media_id;}

    public function getURL(){return $this->url;}
    public function setURL($url){$this->url = $url;}

    public function getArticleId(){return $this->article;}
    public function setArticleId($article){$this->article = $article;}


    public function __construct($media_id = 0, $url = '', $article = 0) {
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

    public function readMedia(): array {
        include_once __DIR__ . "../../config/config.php";
    
        $sqlRead = "SELECT * FROM media WHERE media_id = :media_id;";
    
        try {
            $db = new PDO("mysql:host=" . Database::HOST . "; port=" . Database::PORT . "; dbname=" . Database::DBNAME . "; charset=utf8;", Database::DBUSER, Database::DBPASS);
        
            $reqRead = $db->prepare($sqlRead);
            $reqRead->bindParam(":media_id", $this->media_id, PDO::PARAM_INT);
            
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

    public function findMediaByArticleId($article) {
        include_once __DIR__ . "../../config/config.php";
    
        $sqlSelect = "SELECT * FROM media WHERE article = :article;";
    
        try {
            $db = new PDO("mysql:host=" . Database::HOST . "; port=" . Database::PORT . "; dbname=" . Database::DBNAME . "; charset=utf8;", Database::DBUSER, Database::DBPASS);
        
            $reqSelect = $db->prepare($sqlSelect);
            $reqSelect->bindParam(":article", $article, PDO::PARAM_INT);
            
            if ($reqSelect->execute()) {
                return $reqSelect->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return false;
            }
            

        } catch (Exception | Error $ex) {
            echo $ex->getMessage();
            return false;
        }
    }

    
public function updateMedia() {
    include_once __DIR__ . "../../config/config.php";

    $sqlUpdate = "UPDATE media SET url = :url WHERE media_id = :media_id;";

    try {
        $db = new PDO("mysql:host=" . Database::HOST . "; port=" . Database::PORT . "; dbname=" . Database::DBNAME . "; charset=utf8;", Database::DBUSER, Database::DBPASS);

        $reqUpdate = $db->prepare($sqlUpdate);

        $reqUpdate->bindParam(":url", $this->url, PDO::PARAM_STR);
        $reqUpdate->bindParam(":media_id", $this->media_id, PDO::PARAM_INT);

        if (!$reqUpdate->execute()) {
            throw new Exception("Le média avec l'ID " . $this->media_id . " n'a pas été mis à jour.");
        }

        return true;
    } catch (PDOException $e) {
        if ($e->getCode() === 'HY093') {
            echo 'Erreur dans le fichier ' . __FILE__ . ' à la ligne ' . __LINE__;
        }
        return false;
    } catch (Exception | Error $ex) {
        echo $ex->getMessage();
        return $ex;
    }
}
    
}