<?php

require_once __DIR__. ('../../Utiltary/Log.php');
require_once __DIR__. ('../../models/Cover.php');

class Article {
    private int $articleId = 0;
    private ?string $title = "";
    private ?string $content = "";
    private ?string $image = "";
    private string $date_modified = "";
    private string $date_created = "";
    private int $coverId = 0;

    public function __construct($articleId, $title, $content, $image, $date_modified, $date_created) {
        $this->articleId = 0;
        $this->title = "";
        $this->image = "";
        $this->content = "";
        $this->date_created = "";
        $this->date_modified = "";
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

    /** CRUD operations */

    public function findOneArticleById() {
        include_once __DIR__ . "../../config/config.php";

        $sql = "SELECT * FROM article WHERE articleiD = :articleId";

        try {
            $db = new PDO("mysql:host=" . Database::HOST . "; port=" . Database::PORT . "; dbname=" . Database::DBNAME . "; charset=utf8;", Database::DBUSER, Database::DBPASS);

            $req->bindParam("articleId", $this->articleId, PDO::PARAM_INT);
            $req = $db->prepare($sql);

            $req->bindParam("title", $this->title, PDO::PARAM_STR);
            $req->bindParam("photo", $this->image, PDO::PARAM_STR);
            $req->bindParam("content", $this->content, PDO::PARAM_STR);

            $req->execute();
        } catch (Exception | Error $ex) {
                echo $ex->getMessage();
        }
    }

    public static function findAllArticles(): array {
        include_once __DIR__ . "../../config/config.php";

        $sql = "SELECT article_id, content, image, date_modified, date_created, title, name as category
        FROM article
        INNER JOIN category ON fk_category_article = category_id;";

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

    // Create a new Article //

    public function createArticle(): array {
        include_once __DIR__ . "../../config/config.php";

        $sql = "INSERT INTO article (title, content, image) 
        VALUES 
        (:title, :content, :image);";

        try {
            $db = new PDO("mysql:host=" . Database::HOST . "; port=" . Database::PORT . "; dbname=" . Database::DBNAME . "; charset=utf8;", Database::DBUSER, Database::DBPASS);

            $req = $db->prepare($sql);

            $req->bindParam(":title", $title, PDO::PARAM_STR);
            $req->bindParam(":image", $image, PDO::PARAM_STR);
            $req->bindParam(":content", $content, PDO::PARAM_STR);


            if ($req->execute()) {
            // La requête s'est bien passée !
            return ['success' => true, 'id' => $db->lastInsertId()];
            } else {
            // La requête n'a pu être executée
            return ['success' => false];
            }
        } catch (Exception | Error $ex) {
            echo $ex->getMessage();
            return array();
        }
    }

    // Update an existing article
    public function update()
    {
    }

    // Delete an article by ID
    public function delete($articleId)
    {
         // Assurez-vous que $this->db est une instance de PDO
    $req = $this->db->prepare("DELETE FROM articles WHERE id = :id");
    $req->bindParam(':id', $articleId);
    $req->execute();
    }


}