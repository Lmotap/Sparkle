<?php

require_once __DIR__. ('../../Utiltary/Log.php');
require_once __DIR__. ('../../models/Cover.php');

class Article {
    private int $articleId = 0;
    private ?string $title = "";
    private ?array $content = null;
    private ?array $image = null;
    private string $date_modified = "";
    private string $date_created = "";
    private int $coverId = 0;
    private int $category = 0;

    public function __construct($articleId, $title, $date_modified, $date_created, $category, $content=null, $image=null) {
        $this->articleId = $articleId;
        $this->title = $title;
        $this->content = $content;
        $this->image = $image;
        $this->date_created = $date_modified;
        $this->date_modified = $date_created;
        $this->category = $category;
    }

    /** Les accesseurs magiques */

    public function getId(){return $this->articleId;}
    public function setId($articleId){$this->articleId = $articleId;}

    public function getTitre(){return $this->title;}
    public function setTitre($title){$this->title = $title;}

    public function getContent(){return $this->content;}
    public function setContent($content){$this->content = $content;}

    public function geImage(){return $this->image;}
    public function setImage($image){$this->image = $image;}

    public function getDateModified(){return $this->date_modified;}
    public function setDateModified($date_modified){$this->date_modified = $date_modified;}

    public function getDateCreated(){return $this->date_created;}
    public function setDateCreated($date_created){$this->date_created = $date_created;}

    public function getCoverId(){return $this->coverId;}
    public function setCoverId($coverId){$this->coverId = $coverId;}

    public function getCategory(){return $this->category;}
    public function setCategory($category){$this->category = $category;}

    /** CRUD operations */

    public function findOneArticleById() {
        include_once __DIR__ . "../../config/config.php";

        $sql = "SELECT * FROM article WHERE articleiD = :articleId";

        try {
            $db = new PDO("mysql:host=" . Database::HOST . "; port=" . Database::PORT . "; dbname=" . Database::DBNAME . "; charset=utf8;", Database::DBUSER, Database::DBPASS);

            $req->bindParam("articleId", $this->articleId, PDO::PARAM_INT);
            $req = $db->prepare($sql);

            $req->execute();
        } catch (Exception | Error $ex) {
                echo $ex->getMessage();
        }
    }

    // Permet de trier et d'afficher les articles selon les categories dans la page blog et dashboard
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

    // CRUD operations, CREATE ARTICLE

    public function createArticle(): bool {
        include_once __DIR__ . "../../config/config.php";

        $sql = "INSERT INTO article (title, category) 
        VALUES 
        (:title, :category);";
    
        try {
            $db = new PDO("mysql:host=" . Database::HOST . "; port=" . Database::PORT . "; dbname=" . Database::DBNAME . "; charset=utf8;", Database::DBUSER, Database::DBPASS);
    
            $req = $db->prepare($sql);
    
            $req->bindParam(":title", $this->title, PDO::PARAM_STR);
            $req->bindParam(":category", $this->category, PDO::PARAM_INT);
    
            if ($req->execute()) {
            // La requête s'est bien passée !
                $this->articleId =  $db->lastInsertId();

                return true;
            } else {
            // La requête n'a pu être executée
                return false;
            }
        } catch (Exception | Error $ex) {
            echo $ex->getMessage();
            return false;
        }
    }

    
    public function update()
    {
    }

    // Delete an article by ID
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