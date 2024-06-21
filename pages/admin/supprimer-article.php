<?php
include __DIR__ .  '/../../App/models/Article.php';

$articleId = $_GET['id']; 

$supprimerArticle = Article::delete($articleId);

header('Location: dashboard.php');