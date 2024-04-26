<?php

require_once __DIR__. ('../../Utilitary/Log.php');
require_once __DIR__. ('../../Modal/Cover.php');

class Article {
    private int $articleId = 0;
    private ?string $title = "";
    private ?string $content = "";
    private ?string $image = "";
    private string $date_modified = "";
    private string $date_created = "";
    private int $coverId = 0;

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

    /** CRUD */
    // C for Create
    /**Save in database the current Trombi instance */
    public function createArticle(): bool {
        //var_dump($this);
        //die();
        // Utiliser une constante : __DIR__
        require_once __DIR__. "../../config/config.php";

        $dsn = "mysql:host=" . HOST . ";";
        $dsn .= "port=" . PORT . ";";
        $dsn .= "dbname=" . DBNAME . ";";
        $dsn .= "charset=" . CHARSET . ";";

        // SQL Code of the query C for Creat of the CRUD operations
        //username, firstname, lastname, email, telephone, description, portrait, birthday

        $sql = "INSERT INTO article
                (content, image, title, cover_id, date_modified, date_created)
                VALUES
                (:content, :image, :title, :cover_id, CURRENT_TIMESTAMP(), CURRENT_TIMESTAMP());";

        try {
            $database = new PDO($dsn, DBUSER, DBPASS);
            $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = $database->prepare($sql);
            $query->bindParam(":content", $this->content);
            $query->bindParam(":image", $this->image);
            $query->bindParam(":title", $this->title);
            $query->bindParam(":cover_id", $this->coverId);

            if ($query->execute()) {
                return true;
            } else {
                return false;
            }

        } catch (Exception|Error $exc) {
            Log::log($exc);
            return false;
        }
        
        
    }
}