<?php

require_once __DIR__. ('../../Utilitary/Log.php');


class Cover {
    private int $coverId = 0;
    private ?string $titleCover = "";
    private ?string $imageCover = "";

    public function getCoverId(){return $this->coverId;}
    public function setCoverId($coverId){$this->coverId = $coverId;}

    public function getTitre(){return $this->titleCover;}
    public function setTitre($titleCover){$this->titleCover = $titleCover;}

    public function geImage(){return $this->imageCover;}
    public function setImage($imageCover){$this->imageCover = $imageCover;}

    /** CRUD */
    // C for Create
    /**Save in database the current Trombi instance */
    public function createCover(): bool {
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

        $sql = "INSERT INTO cover
                (titleCover, imageCover)
                VALUES
                (:titleCover, :imageCover);";

        try {
            $database = new PDO($dsn, DBUSER, DBPASS);
            $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = $database->prepare($sql);
            $query->bindParam(":titleCover", $this->titleCover);
            $query->bindParam(":imageCover", $this->imageCover);


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