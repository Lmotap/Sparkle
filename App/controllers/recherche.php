<?php
    require_once __DIR__.  '../../../App/models/Article.php';
    require_once __DIR__. '../../../App/models/Categories.php';

    $categoryName = $_GET['search-bar']; 
    $articlesByCategory = Article::findArticlesByCategory($categoryName);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">

    <!-- CSS !-->
    <link rel="stylesheet" href="../../assets/styles/reset.css">
    <link rel="stylesheet" href="../../assets/styles/layout.css">
    <link rel="stylesheet" href="../../assets/styles/style.css">
    
</head>
<body>
    <header class="dashboard">

        <a href="../../pages/admin/dashboard.php"><img class="logo-img" src="../../assets/img/logo_black.png" alt="Logo du projet"></a>
        <button class="btn_create_article"><a href="create-article.php">+ Créer article</a></button>
        
    </header>

    <div class="container_total_article_btn_search">
        
        <h2 class="title_total_article"><img class="icon_article" src="../../assets/icons/articles.svg" alt="">Total des articles</h2>

        <form action="recherche.php" method="get">
            <div class="search-container">
                <input type="text" name="search-bar" placeholder="Rechercher..." class="search-input">
                <button type="submit" class="search-button"><img class="search-icon" src="../../assets/icons/search-alt.svg" alt=""></button>
            </div>
        </form>
    </div>

    <div class="separateur"></div>

    <div class="container_table">
        <table>
            <thead>
                <tr>
                    <th scope="col">Article ( titre )</th>
                    <th scope="col">ID</th>
                    <th scope="col">Category</th>
                    <th scope="col">Modifier / Supprimer</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach ($articlesByCategory as $article) { 
                ?>
                    <tr>
                        <td><?php echo $article["title"] ?></td>
                        <td><?php echo $article["article_id"] ?></td>
                        <td><?php echo $article["category"] ?></td>
                        <td class="icon_delete_update">
                            <a href="./modifier-article.php?id=<?php echo $article['article_id']; ?>">
                                <img class="icon_dashboard" src="../../assets/icons/pen.svg" alt="">
                            </a>

                            <a href="./supprimer-article.php?id=<?php echo $article['article_id']; ?>">
                                <img class="icon_dashboard" src="../../assets/icons/bin-delete.svg" alt="">
                            </a>
                        </td>
                    </tr>
                <?php
                }
                ?> 
            </tbody>
        </table>
    </div>
</body>
</html>