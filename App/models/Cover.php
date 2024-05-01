<?php

require_once __DIR__. ('../../Utiltary/Log.php');


class Cover {
    private ?int $coverId = 0;
    private ?string $titleCover = "";
    private ?string $imageCover = "";
    private int $article = 0;

    public function __construct(int $coverId = 0 , string $titleCover = '', string $pathCover = '', int $article = 0) {
        $this->coverId = $coverId;
        $this->titleCover = $titleCover;
        $this->imageCover = $pathCover;
        $this->article = $article;
    }

    public function getCoverId(){return $this->coverId;}
    public function setCoverId($coverId){$this->coverId = $coverId;}

    public function getTitreCover(){return $this->titleCover;}
    public function setTitreCover($titleCover){$this->titleCover = $titleCover;}

    public function getImageCover(){return $this->imageCover;}
    public function setImageCover($imageCover){$this->imageCover = $imageCover;}

    public function getArticle(){return $this->article;}
    public function setArticle($article){$this->article = $article;}


    // CRUD operations, CREATE COVER
    public function createCover(): bool {
        include_once __DIR__ . "../../config/config.php";
    
        $sqlInsert = "INSERT INTO cover (titleCover, imageCover, article) VALUES (:titleCover, :imageCover, :article);";
    
        try {
            $db = new PDO("mysql:host=" . Database::HOST . "; port=" . Database::PORT . "; dbname=" . Database::DBNAME . "; charset=utf8;", Database::DBUSER, Database::DBPASS);
        
            $reqInsert = $db->prepare($sqlInsert);
            $reqInsert->bindParam(":titleCover", $this->titleCover, PDO::PARAM_STR);
            $reqInsert->bindParam(":imageCover", $this->imageCover, PDO::PARAM_STR);
            $reqInsert->bindParam(":article", $this->article, PDO::PARAM_INT);
            
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

    public function findCoverByArticleId($article) {
        include_once __DIR__ . "../../config/config.php";
    
        $sqlSelect = "SELECT * FROM cover WHERE article = :article;";
    
        try {
            $db = new PDO("mysql:host=" . Database::HOST . "; port=" . Database::PORT . "; dbname=" . Database::DBNAME . "; charset=utf8;", Database::DBUSER, Database::DBPASS);
        
            $reqSelect = $db->prepare($sqlSelect);
            $reqSelect->bindParam(":article", $article, PDO::PARAM_INT);
            
            // Insérez ces commandes ici
            if ($reqSelect->execute()) {
                return $reqSelect->fetch(PDO::FETCH_ASSOC);
            } else {
                return false;
            }
            
    
        } catch (Exception | Error $ex) {
            echo $ex->getMessage();
            return false;
        }
    }

    public function updateCover($articleId, $postData): bool {
        include_once __DIR__ . "../../config/config.php";
    
        // Récupérez l'ID de la couverture associée à l'article
        $coverData = $this->findCoverByArticleId($articleId);
        if ($coverData === false) {
            throw new Exception("Aucune couverture trouvée pour l'article avec l'ID " . $articleId);
        }
        $this->coverId = $coverData['cover_id'];
    
        // Mettez à jour la couverture
        $sqlUpdate = "UPDATE cover SET titleCover = :titleCover, imageCover = :imageCover, article = :article WHERE cover_id = :cover_id;";
    
        try {
            $db = new PDO("mysql:host=" . Database::HOST . "; port=" . Database::PORT . "; dbname=" . Database::DBNAME . "; charset=utf8;", Database::DBUSER, Database::DBPASS);
    
            $reqUpdate = $db->prepare($sqlUpdate);
    
            $this->titleCover = $postData['titleCover'];
            $reqUpdate->bindParam(":titleCover", $this->titleCover, PDO::PARAM_STR);
    
            $this->imageCover = isset($postData['imageCover']) ? $postData['imageCover'] : '';
            $reqUpdate->bindParam(":imageCover", $this->imageCover, PDO::PARAM_STR);
    
            $this->article = $articleId;
            $reqUpdate->bindParam(":article", $this->article, PDO::PARAM_INT);
    
            $reqUpdate->bindParam(":cover_id", $this->coverId, PDO::PARAM_INT);

            var_dump($this->titleCover);
            var_dump($this->imageCover);
            var_dump($this->article);
            var_dump($this->coverId);
    
            if ($reqUpdate->execute()) {
                return true;
            } else {
                throw new Exception("La couverture n'a pas été mise à jour.");
            }
        } catch (PDOException $e) {
            if ($e->getCode() === 'HY093') {
                echo 'Erreur dans le fichier ' . __FILE__ . ' à la ligne ' . __LINE__;
            }
            return false;
        } catch (Exception | Error $ex) {
            echo $ex->getMessage();
            return false;
        }
    }
}