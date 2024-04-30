<?php

require_once __DIR__. ('../../Utiltary/Log.php');

class Media {
    private int $media_id = 0;
    private ?string $url = "";
    private int $article = 0;


    public function __construct($media_id, $url, $article) {
        $this->media_id = $media_id;
        $this->url = $url;
        $this->article = $article;
    }
}