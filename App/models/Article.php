<?php

require_once __DIR__. ('../../Utiltary/Log.php');
require_once __DIR__. ('../../models/Cover.php');

class Article {
    private ?int $articleId = 0;
    private ?string $title = "";
    private ?array $content = null;
    private ?array $image = null;
    private string $date_modified = "";
    private string $date_created = "";
    private int $coverId = 0;
    private int $category = 0;
    private int $created_by = 0;

    public function __construct($articleId = 0, $title = '', $date_modified = '', $date_created = '', $category = 0,$created_by = 0, $content=null, $image=null) {
        $this->articleId = $articleId;
        $this->title = $title;
        $this->content = $content;
        $this->image = $image;
        $this->date_modified = $date_created;
        $this->date_created = $date_modified;
        $this->category = $category;
        $this->created_by = $created_by;
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

    public function getAdmin(){return $this->created_by;}
    public function setAdmin($created_by){$this->created_by = $created_by;}

    /** CRUD operations */

    public function getFullArticle($articleId) {
        // Récupérez les informations de l'article
        $articleInfo = $this->findArticleById($articleId);

        // Récupérez les informations de la couverture de l'article
        $cover = new Cover();
        $coverInfo = $cover->findCoverByArticleId($articleId);

        // Récupérez les paragraphes de l'article
        $paragraph = new Paragraph();
        $paragraphsInfo = $paragraph->findParagraphsByArticleId($articleId);

        // Récupérez les médias de l'article
        $media = new Media();
        $mediasInfo = $media->findMediaByArticleId($articleId);

        // Retournez toutes les informations
        return [
            'article' => $articleInfo,
            'cover' => $coverInfo,
            'paragraphs' => $paragraphsInfo,
            'medias' => $mediasInfo,
        ];
    }

    public function updateFullArticle($articleId, $postData) {
        // Mettez à jour l'article
        $this->setTitre($postData['title']);
        if (isset($postData['category'])) {
            // Convertissez la valeur en int avant de l'attribuer à la propriété category
            $this->setCategory(intval($postData['category']));
        } else {
            // Si la clé "category" n'existe pas, attribuez une valeur par défaut à la propriété category
            $this->setCategory(0);
        }
        // Vérifiez si la clé "admin" existe dans le tableau $postData
    if (isset($postData['created_by'])) {
        // Convertissez la valeur en int avant de l'attribuer à la propriété created_by
        $this->setAdmin(intval($postData['created_by']));
    } else {
        // Si la clé "admin" n'existe pas, attribuez une valeur par défaut à la propriété created_by
        $this->setAdmin(0);
    }
        $this->updateArticle();

       // Mettez à jour la couverture
    $cover = new Cover();
    $cover->setTitreCover($postData['titleCover']);
    if (isset($postData['imageCover'])) {
        $cover->setImageCover($postData['imageCover']);
    } else {
        $cover->setImageCover(''); // valeur par défaut si 'imageCover' n'est pas défini
    }
    $cover->updateCover($articleId, $_POST);

        // Mettez à jour les paragraphes
        $paragraph = new Paragraph();
        if (is_array($postData['content'])) {
            foreach ($postData['content'] as $paragraphId => $content) {
                $paragraph->updateParagraph($articleId, $paragraphId, $content);
            }
        }

        // Mettez à jour les médias
        $media = new Media();
    if (isset($postData['url']) && is_array($postData['url'])) {
        foreach ($postData['url'] as $mediaId => $url) {
            $media->setUrl($url);
            $media->updateMedia();
        }
    }
}

    public function findArticleById($articleId) {
        include_once __DIR__ . "../../config/config.php";
    
        $sql = "SELECT * FROM article WHERE article_id = :article_id;";
    
        try {
            $db = new PDO("mysql:host=" . Database::HOST . "; port=" . Database::PORT . "; dbname=" . Database::DBNAME . "; charset=utf8;", Database::DBUSER, Database::DBPASS);
    
            $req = $db->prepare($sql); // Préparez la requête en premier
    
            $req->bindParam(":article_id", $articleId, PDO::PARAM_INT); // Ensuite, liez les paramètres
    
            $req->execute();
            return $req->fetchAll();
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
    
            // Get current date and time
            $date_modified = date('Y-m-d H:i:s');
            $req->bindParam(":date_modified", $date_modified, PDO::PARAM_STR);

            // Get current date and time
            $date_created = date('Y-m-d H:i:s');
            $req->bindParam(":date_created", $date_created, PDO::PARAM_STR);
    
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