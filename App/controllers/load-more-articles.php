<?php

require_once __DIR__ . '/../models/Article.php';

$page = isset($_GET['page']) ? $_GET['page'] : 1;

$start = ($page - 1) * 5;

$articles = Article::getArticlesWithCoverAndCategory();

$articles = array_slice($articles, $start, 5);

header('Content-Type: application/json');
echo json_encode($articles);
