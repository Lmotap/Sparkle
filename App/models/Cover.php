<?php

require_once __DIR__. ('../../Utiltary/Log.php');


class Cover {
    private int $coverId = 0;
    private ?string $titleCover = "";
    private ?string $imageCover = "";
    private int $fk_article_cover = 0;

    public function __construct($coverId, $titleCover, $imageCover) {
        $this->coverId = 0;
        $this->titleCover = "";
        $this->imageCover = "";
        $this->fk_article_cover = 0;
    }

    public function getCoverId(){return $this->coverId;}
    public function setCoverId($coverId){$this->coverId = $coverId;}

    public function getTitre(){return $this->titleCover;}
    public function setTitre($titleCover){$this->titleCover = $titleCover;}

    public function geImage(){return $this->imageCover;}
    public function setImage($imageCover){$this->imageCover = $imageCover;}


    // CRUD operations, CREATE COVER
    public function createCover(): array {
        include_once __DIR__ . "../../config/config.php";
    
        $sqlInsert = "INSERT INTO cover (titleCover, imageCover, fk_article_cover) VALUES (:titleCover, :imageCover, :fk_article_cover);";
    
        try {
            $db = new PDO("mysql:host=" . Database::HOST . "; port=" . Database::PORT . "; dbname=" . Database::DBNAME . "; charset=utf8;", Database::DBUSER, Database::DBPASS);
        
            $reqInsert = $db->prepare($sqlInsert);
            $reqInsert->bindParam(":titleCover", $this->titleCover, PDO::PARAM_STR);
            $reqInsert->bindParam(":imageCover", $this->imageCover, PDO::PARAM_STR);
            $reqInsert->bindParam(":fk_article_cover", $this->fk_article_cover, PDO::PARAM_INT);
            
            // Insérez ces commandes ici
            $result = $reqInsert->execute();
            var_dump($result);
            
            if ($result) {
                // La requête s'est bien passée !
                return ['success' => true, 'id' => $db->lastInsertId()];
            } else {
                // La requête n'a pu être executée
                return ['success' => false, 'error' => $reqInsert->errorInfo()];
            }
        } catch (Exception | Error $ex) {
            echo $ex->getMessage();
            return ['success' => false, 'error' => $ex->getMessage()];
        }
    }

}