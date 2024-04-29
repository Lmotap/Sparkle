<?php
include __DIR__ .  '../../App/models/Article.php';

$articleId = $_GET['id'];
delete($articleId);

// Redirigez l'utilisateur vers la page du tableau de bord après la suppression
header('Location: dashboard.php');
?>