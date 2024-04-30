<?php

require_once __DIR__. ('../../Utiltary/Log.php');


class Cover {
    private int $coverId = 0;
    private ?string $titleCover = "";
    private ?string $imageCover = "";

    public function __construct($coverId, $titleCover, $imageCover) {
        $this->coverId = 0;
        $this->titleCover = "";
        $this->imageCover = "";
    }

    public function getCoverId(){return $this->coverId;}
    public function setCoverId($coverId){$this->coverId = $coverId;}

    public function getTitre(){return $this->titleCover;}
    public function setTitre($titleCover){$this->titleCover = $titleCover;}

    public function geImage(){return $this->imageCover;}
    public function setImage($imageCover){$this->imageCover = $imageCover;}

    public function createCover() {
        include_once __DIR__ . "../../config/config.php";

        $sql = "INSERT INTO cover (titleCover, imageCover) 
        VALUES 
        (:titleCover, :imageCover);";

        try {
            $db = new PDO("mysql:host=" . Database::HOST . "; port=" . Database::PORT . "; dbname=" . Database::DBNAME . "; charset=utf8;", Database::DBUSER, Database::DBPASS);

            $req = $db->prepare($sql);

            $req->bindParam(":titleCover", $title, PDO::PARAM_STR);
            $req->bindParam(":imageCover", $image, PDO::PARAM_STR);
            
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

}