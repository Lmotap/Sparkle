<?php

require_once __DIR__. ('../../Utiltary/Log.php');

class Paragraph {
    private ?int $paraph_id = 0;
    private ?string $content = "";
    private int $article = 0;


    public function __construct($paraph_id = 0, $content = '', $article = 0) {
        $this->paraph_id = $paraph_id;
        $this->content = $content;
        $this->article = $article;
    }

    public function getParagraphId(){return $this->paraph_id;}
    public function setParagraphId($paraph_id){$this->paraph_id = $paraph_id;}

    public function getContent(){return $this->content;}
    public function setContent($content){$this->content = $content;}

    public function getArticleId(){return $this->article;}
    public function setArticleId($article){$this->article = $article;}

    // Créer un paragraphe 

    public function createParagraph(): bool {
        include_once __DIR__ . "../../config/config.php";
    
        $sqlInsert = "INSERT INTO paragraph (content, article) VALUES (:content, :article);";
    
        try {
            $db = new PDO("mysql:host=" . Database::HOST . "; port=" . Database::PORT . "; dbname=" . Database::DBNAME . "; charset=utf8;", Database::DBUSER, Database::DBPASS);
        
            $reqInsert = $db->prepare($sqlInsert);
            $reqInsert->bindParam(":content", $this->content, PDO::PARAM_STR);
            $reqInsert->bindParam(":article", $this->article, PDO::PARAM_INT);

            // Debug: Afficher les valeurs de content et article
            var_dump($this->content, $this->article);
            
            // Insérez ces commandes ici
            if ($reqInsert->execute()) {
                $this->paraph_id = $db->lastInsertId();
                return true;
            } else {
            // Debug: Afficher l'erreur
            var_dump($reqInsert->errorInfo());
            return false;
            }
        } catch (Exception | Error $ex) {
            echo $ex->getMessage();
            return false;
        }
    }

    public function readParagraph(): array {
        include_once __DIR__ . "../../config/config.php";
    
        $sql = "SELECT * FROM paragraph WHERE article = :article;";
    
        try {
            $db = new PDO("mysql:host=" . Database::HOST . "; port=" . Database::PORT . "; dbname=" . Database::DBNAME . "; charset=utf8;", Database::DBUSER, Database::DBPASS);
        
            $req = $db->prepare($sql);
            $req->bindParam(":article", $this->article, PDO::PARAM_INT);
            
            // Insérez ces commandes ici
            if ($req->execute()) {
                $results = $req->fetchAll(PDO::FETCH_ASSOC);
                return $results;
            } else {
                return array();
            }
            

        } catch (Exception | Error $ex) {
            echo $ex->getMessage();
            return array();
        }
    }

    public function findParagraphsByArticleId($article) {
        include_once __DIR__ . "../../config/config.php";
    
        $sqlSelect = "SELECT * FROM paragraph WHERE article = :article;";
    
        try {
            $db = new PDO("mysql:host=" . Database::HOST . "; port=" . Database::PORT . "; dbname=" . Database::DBNAME . "; charset=utf8;", Database::DBUSER, Database::DBPASS);
        
            $reqSelect = $db->prepare($sqlSelect);
            $reqSelect->bindParam(":article", $article, PDO::PARAM_INT);
            
            // Insérez ces commandes ici
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

    public function updateParagraph($articleId, $paraph_id, $content): bool {
        include_once __DIR__ . "../../config/config.php";
    
        $sqlUpdate = "UPDATE paragraph SET content = :content, article = :article WHERE paraph_id = :paraph_id;";
    
        try {
            $db = new PDO("mysql:host=" . Database::HOST . "; port=" . Database::PORT . "; dbname=" . Database::DBNAME . "; charset=utf8;", Database::DBUSER, Database::DBPASS);
    
            $reqUpdate = $db->prepare($sqlUpdate);
    
            $this->content = isset($content) ? $content : '';
            $reqUpdate->bindParam(":content", $this->content, PDO::PARAM_STR);

            $this->article = $articleId;
            $reqUpdate->bindParam(":article", $this->article, PDO::PARAM_INT);

            $this->paraph_id = $paraph_id;
            $reqUpdate->bindParam(":paraph_id", $this->paraph_id, PDO::PARAM_INT);
        
            var_dump($this->content);
            var_dump($this->article);
            var_dump($this->paraph_id);
    
            if (!$reqUpdate->execute()) {
                throw new Exception("Le paragraphe avec l'ID " . $paraph_id . " n'a pas été mis à jour.");
            }
    
            return true;
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