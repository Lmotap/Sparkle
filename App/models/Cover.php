<?php

require_once __DIR__. ('../../Utiltary/Log.php');


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

}