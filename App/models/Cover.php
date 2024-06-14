<?php


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
    
            if ($reqSelect->execute()) {
                $result = $reqSelect->fetch(PDO::FETCH_ASSOC);
                
                return $result;
            } else {
                echo "Erreur lors de l'exécution de la requête SQL : " . $db->errorInfo()[2];
                return false;
            }
        } catch (Exception | Error $ex) {
            echo $ex->getMessage();
            return false;
        }
    }
    
    public function updateCover(): bool {
        include_once __DIR__ . "../../config/config.php";
    
        $sql = "UPDATE cover SET cover_id = :cover_id, titleCover = :titleCover,  imageCover = :imageCover WHERE article = :article;";
    
        try {

            $db = new PDO("mysql:host=" . Database::HOST . "; port=" . Database::PORT . "; dbname=" . Database::DBNAME . "; charset=utf8;", Database::DBUSER, Database::DBPASS);
    
            $req = $db->prepare($sql);
    
            $req->bindParam(":titleCover", $this->titleCover, PDO::PARAM_STR);
            
    
            $req->bindParam(":imageCover", $this->imageCover, PDO::PARAM_STR);
    
            $req->bindParam(":article", $this->article, PDO::PARAM_INT);
            

            $req->bindParam(":cover_id", $this->coverId, PDO::PARAM_INT);
            
    
            try {
                if ($req->execute()) {
                    return true;
                } else {
                    throw new Exception("Impossible de mettre à jour l'article.");
                }
            } catch (PDOException $e) {
                if ($e->getCode() === 'HY093') {
                    echo 'Erreur dans le fichier ' . __FILE__ . ' à la ligne ' . __LINE__;
                }
                return false;
            }
        } catch (Exception | Error $ex) {
            echo $ex->getMessage();
            return false;
        }
    }
}