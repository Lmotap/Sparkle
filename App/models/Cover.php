<?php

require_once __DIR__. ('../../Utiltary/Log.php');


class Cover {
    private int $coverId = 0;
    private ?string $titleCover = "";
    private ?string $imageCover = "";
    private int $fk_article_cover = 0;

    public function __construct(int $coverId , string $titleCover, string $pathCover, int $article) {
        $this->coverId = $coverId;
        $this->titleCover = $titleCover;
        $this->imageCover = $pathCover;
        $this->fk_article_cover = $article;
    }

    public function getCoverId(){return $this->coverId;}
    public function setCoverId($coverId){$this->coverId = $coverId;}

    public function getTitre(){return $this->titleCover;}
    public function setTitre($titleCover){$this->titleCover = $titleCover;}

    public function geImage(){return $this->imageCover;}
    public function setImage($imageCover){$this->imageCover = $imageCover;}


    // CRUD operations, CREATE COVER
    public function createCover(): bool {
        include_once __DIR__ . "../../config/config.php";
    
        $sqlInsert = "INSERT INTO cover (titleCover, imageCover, article) VALUES (:titleCover, :imageCover, :article);";
    
        try {
            $db = new PDO("mysql:host=" . Database::HOST . "; port=" . Database::PORT . "; dbname=" . Database::DBNAME . "; charset=utf8;", Database::DBUSER, Database::DBPASS);
        
            $reqInsert = $db->prepare($sqlInsert);
            $reqInsert->bindParam(":titleCover", $this->titleCover, PDO::PARAM_STR);
            $reqInsert->bindParam(":imageCover", $this->imageCover, PDO::PARAM_STR);
            $reqInsert->bindParam(":article", $this->fk_article_cover, PDO::PARAM_INT);
            
            // Insérez ces commandes ici
           if ($reqInsert->execute()) {
                $this->coverId = $db->lastInsertId();
                return true;
           } else {
                return false;
            }
              

        } catch (Exception | Error $ex) {
            echo $ex->getMessage();
            return false;
        }
    }

}