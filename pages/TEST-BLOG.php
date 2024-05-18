<?php

require_once __DIR__ . '/../App/models/Article.php';

$articles = Article::getArticlesWithCoverAndCategory();

$articles = array_slice($articles, 0, 5);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog de photographie de Lucas Mota : Conseils photographies & Inspirations urbaines</title>

    <meta name="description" content="Des conseils pratiques aux réflexions sur la photographie de rue, découvrez les articles de Lucas Mota, photographe utilisant le Fujifilm X-T30 II pour capturer la vie urbaine et sauvage sous tous ses angles">


    <!-- Favicon -->
    <link rel="shortcut icon" href="../assets/img/favicon.ico" type="image/x-icon">

    <!-- CSS !-->
    <link rel="stylesheet" href="../assets/styles/reset.css">
    <link rel="stylesheet" href="../assets/styles/layout.css">
    <link rel="stylesheet" href="../assets/styles/style.css">

</head>

<body>

    <!-- Début du header -->

    <header>
        <a href="../index.html"><img id="logo-img" src="../assets/img/logo_black.png" alt="Logo du projet"></a>
        <div class="container-icon-dyslexic">
            <a id="dyslexic" area-label="Adapter la police de caractères"><img class="icon_dyslexic" src="../assets/img/logo-dyslexique.png" alt="Logo Dislexique"></a>
        </div>
        <nav>
            <ul>
                <li id="show_hamburger">
                    <span id="nav-show" data-target=".collapse"><img id="icon_hamburger" src="../assets/icons/burger-list.svg" alt="Icône de burger"></span>
                </li>
                <li id="close_hamburger">
                <span id="nav-hide" data-target=".collapse" class="hide"><img id="icon_cross_ham" src="../assets/icons/cross-burger.svg" alt="Icône de fermeture"></span>
                </li>
                <div class="collapse hide">
                    
                <div class="nav-left nav-variant">
                    <li class="link_nav"><a href="../pages/category_photos.html">Portfolio</a></li>
                    <li class="link_nav"><a href="./blog.html">Blog</a></li>
                    <li class="link_nav"><a href="./contact.html">Contact</a></li>
                </div>
                
                <div class="nav-right nav-variant_newsletters">
                    <li class="link_nav"><a href="./contact.html">Newsletters</a></li>
                </div>
                    <li>
                    </li>
                </div>
            </ul>
        </nav>
    </header>

        <div class="box_bio_article">
            <h1 class="titre_page"> Qui suis-je ?</h1>
                <img src="../assets/img/bio_img.jpg" alt="Photo d'un équipement de photographie posé sur une carte">
        </div>

        <div class="container_separation">
            <div class="separation_main"></div>
        </div>

        <?php foreach ($articles as $article): ?>
            <div class="container_article">
    <div class="img wrapper">
        <a class="link_article" href="./article/article.html">
            <img class="cover_img" src="<?php echo substr($article->imageCover, 3); ?>" alt="">        
        </a>
        <span class="tag_article"><?php echo $article->name; ?></span>
    </div>
    <h2 class="titre_article"><?php echo $article->titleCover; ?></h2>
</div>
<?php endforeach; ?>

    <div class="container_btn_more_article">
        <button class="btn_more_article">
            <span class="text">Plus d'articles</span>
            <span aria-hidden="" class="marquee">Plus d'articles</span>
        </button>
    </div>

<!-- Début du Footer -->

<footer class="footer">
    <ul class="container_icon">
        <img src="../assets/icons/instagram_icon.svg" alt="Icône d'instagram">
        <img src="../assets/icons/twitter-x.svg" alt="Icône X">
    </ul>

    <ul class="nav_footer_center">
        <li class="link_footer">Lucas Mota</li>
    </ul>

    <ul class="nav_footer_right">
        <li class="link_footer wth_link">Mentions <br>légales</li>
        <div class="diese">&</div>
        <li class="link_footer wth_link">Politique de <br>confidentialités</li>
    </ul>
</footer>

<script src="../js/app.js"></script>
</body>
</html>