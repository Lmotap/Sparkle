<?php

require_once __DIR__ . '/../models/Article.php';

// Récupérer le numéro de page de la requête, ou utiliser 1 par défaut
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Calculer l'index du premier article à charger
$start = ($page - 1) * 5;

// Récupérer les articles de la base de données
$articles = Article::getArticlesWithCoverAndCategory();

// Limiter à 5 articles à partir de l'index de départ
$articles = array_slice($articles, $start, 5);

// Renvoyez les articles en format JSON
header('Content-Type: application/json');
echo json_encode($articles);
