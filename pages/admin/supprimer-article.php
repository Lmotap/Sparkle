<?php
include __DIR__ .  '/../../App/models/Article.php';

$articleId = $_GET['id']; // Récupère l'ID de l'article à partir de la requête GET

$supprimerArticle = Article::delete($articleId);

// Redirigez l'utilisateur vers la page du tableau de bord après la suppression
header('Location: dashboard.php');