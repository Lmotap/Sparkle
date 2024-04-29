<?php

require_once __DIR__. ('../../Utiltary/Log.php');


class Category {
    private int $categoryId = 0;
    private string $name = "";

        public function getId(){return $this->categoryId;}
        public function setId($categoryId){$this->categoryId = $categoryId;}
    
        public function getPseudo(){return $this->name;}
        public function setPseudo($name){$this->name = $name;}

}