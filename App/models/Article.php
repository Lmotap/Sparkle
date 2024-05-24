<?php

require_once __DIR__. ('../../Utiltary/Log.php');
require_once __DIR__. ('../../models/Cover.php');
require_once __DIR__. ('../../models/Paragraph.php');
require_once __DIR__. ('../../models/Media.php');   

class Article {
    private ?int $articleId = 0;
    private ?string $title = "";
    private string $date_modified = "";
    private string $date_created = "";
    private int $category = 0;
    private int $created_by = 0;

    public function __construct($articleId = 0, $title = '', $date_modified = '', $date_created = '', $category = 0,$created_by = 0) {
        $this->articleId = $articleId;
        $this->title = $title;
        $this->date_modified = $date_modified;
        $this->date_created = $date_created;
        $this->category = $category;
        $this->created_by = $created_by;
    }

    /** Les accesseurs magiques */

    public function getId(){return $this->articleId;}
    public function setId($articleId){$this->articleId = $articleId;}

    public function getTitre(){return $this->title;}
    public function setTitre($title){$this->title = $title;}

    public function getDateModified(){return $this->date_modified;}
    public function setDateModified($date_modified){$this->date_modified = $date_modified;}

    public function getDateCreated(){return $this->date_created;}
    public function setDateCreated($date_created){$this->date_created = $date_created;}

    public function getCategory(){return $this->category;}
    public function setCategory($category){$this->category = $category;}

    public function getAdmin(){return $this->created_by;}
    public function setAdmin($created_by){$this->created_by = $created_by;}


public static function getArticlesWithCoverAndCategory() {
    include_once __DIR__ . "../../config/config.php";

    
    $db = new PDO("mysql:host=" . Database::HOST . "; port=" . Database::PORT . "; dbname=" . Database::DBNAME . "; charset=utf8;", Database::DBUSER, Database::DBPASS);

    
    $stmt = $db->prepare("
        SELECT article.*, article.article_id, cover.imageCover, cover.titleCover, category.name
        FROM article
        LEFT JOIN cover ON cover.article = article.article_id
        LEFT JOIN category ON article.category = category.category_id
        ORDER BY article.date_created DESC
    ");

    $stmt->execute();

    $articles = $stmt->fetchAll(PDO::FETCH_OBJ);

    if (!$articles) {
        echo "Aucun article trouvé";
        exit;
    }

    return $articles;
}

    /** CRUD operations */

    public function getFullArticle($articleId) {

        $articleInfo = $this->findArticleById($articleId);

        $cover = new Cover();
        $coverInfo = $cover->findCoverByArticleId($articleId);

        $paragraph = new Paragraph();
        $paragraphsInfo = $paragraph->findParagraphsByArticleId($articleId);

        $media = new Media();
        $mediasInfo = $media->findMediaByArticleId($articleId);

        return [
            'article' => $articleInfo,
            'cover' => $coverInfo,
            'paragraphs' => $paragraphsInfo,
            'medias' => $mediasInfo,
        ];
    }

    public static function findArticleById($articleId) {
        include_once __DIR__ . "../../config/config.php";
    
        $sql = "SELECT article.*, category.name as category 
        FROM article 
        INNER JOIN category ON article.category = category.category_id 
        WHERE article.article_id = :article_id;";
    
        try {
            $db = new PDO("mysql:host=" . Database::HOST . "; port=" . Database::PORT . "; dbname=" . Database::DBNAME . "; charset=utf8;", Database::DBUSER, Database::DBPASS);
    
            $req = $db->prepare($sql); 
    
            $req->bindParam(":article_id", $articleId, PDO::PARAM_INT); 
    
            $req->execute();
            return $req->fetch();
        } catch (Exception | Error $ex) {
                echo $ex->getMessage();
        }
    }

    public function findParagraphsByArticleId($article) {
        include_once __DIR__ . "../../config/config.php";
    
        $sqlSelect = "SELECT * FROM paragraph WHERE article = :article; ORDER BY paraph_id";
    
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

    public function findMediaByArticleId($article) {
        include_once __DIR__ . "../../config/config.php";
    
        $sqlSelect = "SELECT * FROM media WHERE article = :article ORDER BY media_id;";
    
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
    
    public static function findArticlesByCategory($categoryName) {

        include_once __DIR__ . "../../config/config.php";

        $db = new PDO("mysql:host=" . Database::HOST . "; port=" . Database::PORT . "; dbname=" . Database::DBNAME . "; charset=utf8;", Database::DBUSER, Database::DBPASS);

        $req = $db->prepare('SELECT article_id, date_modified, date_created, title, name as category 
        FROM article 
        INNER JOIN category ON category = category_id WHERE category.name = :categoryName;');
        $req->execute(array('categoryName' => $categoryName));
        return $req->fetchAll();
    }

    public static function findAllArticles(): array {
        include_once __DIR__ . "../../config/config.php";

        $sql = "SELECT article_id, date_modified, date_created, title, name as category
        FROM article
        INNER JOIN category ON category = category_id;";

        try {
            $db = new PDO("mysql:host=" . Database::HOST . "; port=" . Database::PORT . "; dbname=" . Database::DBNAME . "; charset=utf8;", Database::DBUSER, Database::DBPASS);

            $req = $db->prepare($sql);
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


    public function createArticle(): bool {
        include_once __DIR__ . "../../config/config.php";

        $sql = "INSERT INTO article (title, category, created_by) 
        VALUES 
        (:title, :category, :created_by);";
    
        try {
            $db = new PDO("mysql:host=" . Database::HOST . "; port=" . Database::PORT . "; dbname=" . Database::DBNAME . "; charset=utf8;", Database::DBUSER, Database::DBPASS);
    
            $req = $db->prepare($sql);
    
            $req->bindParam(":title", $this->title, PDO::PARAM_STR);
            $req->bindParam(":category", $this->category, PDO::PARAM_INT);
            $req->bindParam(":created_by", $this->created_by, PDO::PARAM_INT);
    
            if ($req->execute()) {
                $this->articleId =  $db->lastInsertId();

                return true;
            } else {

                return false;
            }
        } catch (Exception | Error $ex) {
            echo $ex->getMessage();
            return false;
        }
    }

    
    public function updateArticle(): bool {
        include_once __DIR__ . "../../config/config.php";
    
        $sql = "UPDATE article SET title = :title, category = :category, created_by = :created_by, date_created = :date_created, date_modified = :date_modified WHERE article_id = :article_id;";
    
        try {
            $db = new PDO("mysql:host=" . Database::HOST . "; port=" . Database::PORT . "; dbname=" . Database::DBNAME . "; charset=utf8;", Database::DBUSER, Database::DBPASS);
    
            $req = $db->prepare($sql);
    
            $req->bindParam(":title", $this->title, PDO::PARAM_STR);
    
            $req->bindParam(":category", $this->category, PDO::PARAM_INT);
    
            $req->bindParam(":created_by", $this->created_by, PDO::PARAM_INT);
    
            $req->bindParam(":article_id", $this->articleId, PDO::PARAM_INT);
    
            $date_modified = date('Y-m-d H:i:s');
            $req->bindParam(":date_modified", $date_modified, PDO::PARAM_STR);
    
            $date_created = date('Y-m-d H:i:s');
            $req->bindParam(":date_created", $date_created, PDO::PARAM_STR);
    
            if ($req->execute()) {
                return true;
            } else {
                throw new Exception("Impossible de mettre à jour l'article.");
            }
        } catch (Exception | Error $ex) {
            echo $ex->getMessage();
            return false;
        }
    }

    public static function delete($articleId)
    {
        include_once __DIR__ . "../../config/config.php";

        $sql = "DELETE FROM article WHERE article_id = :article_id;";
        $db = new PDO("mysql:host=" . Database::HOST . "; port=" . Database::PORT . "; dbname=" . Database::DBNAME . "; charset=utf8;", Database::DBUSER, Database::DBPASS);
    
        $req = $db->prepare($sql);
        $req->bindParam(':article_id', $articleId);
        $req->execute();
    }
}